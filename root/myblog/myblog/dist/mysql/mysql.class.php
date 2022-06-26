<?php
 
 
class MMysql {
     
    protected static $_dbh = null; //��̬����,�������ݿ�ʵ������,�����ظ��������ݿ�
    protected $_dbType = 'mysql';
    protected $_pconnect = true; //�Ƿ�ʹ�ó�����
    protected $_host = 'localhost';
    protected $_port = 3307;
    protected $_user = 'root';
    protected $_pass = 'root';
    protected $_dbName = null; //���ݿ���
    protected $_sql = false; //���һ��sql���
    protected $_where = '';
    protected $_order = '';
    protected $_limit = '';
    protected $_field = '*';
    protected $_clear = 0; //״̬��0��ʾ��ѯ�����ɾ���1��ʾ��ѯ������Ⱦ
    protected $_trans = 0; //����ָ���� 
  
    /**
     * ��ʼ����
     * @param array $conf ���ݿ�����
     */
    public function __construct(array $conf) {
        class_exists('PDO') or die("PDO: class not exists.");
        $this->_host = $conf['host'];
        $this->_port = $conf['port'];
        $this->_user = $conf['user'];
        $this->_pass = $conf['passwd'];
        $this->_dbName = $conf['dbname'];
        //�������ݿ�
        if ( is_null(self::$_dbh) ) {
            $this->_connect();
        }
    }
     
    /**
     * �������ݿ�ķ���
     */
    protected function _connect() {
        $dsn = $this->_dbType.':host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbName;
        $options = $this->_pconnect ? array(PDO::ATTR_PERSISTENT=>true) : array();
        try { 
            $dbh = new PDO($dsn, $this->_user, $this->_pass, $options);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //�������sql���ִ�д������׳��쳣��������Զ��ع�
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //����prepared statements�ķ���Ч��(��SQLע��)
        } catch (PDOException $e) { 
            die('Connection failed: ' . $e->getMessage());
        }
        $dbh->exec('SET NAMES utf8');
        self::$_dbh = $dbh;
    }
 
    /** 
    * �ֶκͱ������� `����
    * ��ָ֤����ʹ�ùؼ��ֲ����� ���mysql 
    * @param string $value 
    * @return string 
    */ 
    protected function _addChar($value) { 
        if ('*'==$value || false!==strpos($value,'(') || false!==strpos($value,'.') || false!==strpos($value,'`')) { 
            //�������* ���� ʹ����sql���� �������� 
        } elseif (false === strpos($value,'`') ) { 
            $value = '`'.trim($value).'`';
        } 
        return $value; 
    }
     
    /** 
    * ȡ�����ݱ����ֶ���Ϣ 
    * @param string $tbName ����
    * @return array 
    */ 
    protected function _tbFields($tbName) {
        $sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME="'.$tbName.'" AND TABLE_SCHEMA="'.$this->_dbName.'"';
        $stmt = self::$_dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ret = array();
        foreach ($result as $key=>$value) {
            $ret[$value['COLUMN_NAME']] = 1;
        }
        return $ret;
    }
 
    /** 
    * ���˲���ʽ�����ݱ��ֶ�
    * @param string $tbName ���ݱ��� 
    * @param array $data POST�ύ���� 
    * @return array $newdata 
    */
    protected function _dataFormat($tbName,$data) {
        if (!is_array($data)) return array();
        $table_column = $this->_tbFields($tbName);
        $ret=array();
        foreach ($data as $key=>$val) {
            if (!is_scalar($val)) continue; //ֵ���Ǳ���������
            if (array_key_exists($key,$table_column)) {
                $key = $this->_addChar($key);
                if (is_int($val)) { 
                    $val = intval($val); 
                } elseif (is_float($val)) { 
                    $val = floatval($val); 
                } elseif (preg_match('/^\(\w*(\+|\-|\*|\/)?\w*\)$/i', $val)) {
                    // ֧�����ֶε�ֵ����ֱ��ʹ�������ֶ� ,���� (score+1) (name) �����������
                    $val = $val;
                } elseif (is_string($val)) { 
                    $val = '"'.addslashes($val).'"';
                }
                $ret[$key] = $val;
            }
        }
        return $ret;
    }
     
    /**
    * ִ�в�ѯ ��Ҫ��� SELECT, SHOW ��ָ��
    * @param string $sql sqlָ�� 
    * @return mixed 
    */ 
    protected function _doQuery($sql='') {
        $this->_sql = $sql;
        $pdostmt = self::$_dbh->prepare($this->_sql); //prepare����query ����һ��PDOStatement
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     
    /** 
    * ִ����� ��� INSERT, UPDATE �Լ�DELETE,exec���������Ӱ�������
    * @param string $sql sqlָ�� 
    * @return integer 
    */ 
    protected function _doExec($sql='') {
        $this->_sql = $sql;
        return self::$_dbh->exec($this->_sql);
    }
 
    /** 
    * ִ��sql��䣬�Զ��жϽ��в�ѯ����ִ�в��� 
    * @param string $sql SQLָ�� 
    * @return mixed 
    */ 
    public function doSql($sql='') {
        $queryIps = 'INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|SELECT .* INTO|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK'; 
        if (preg_match('/^\s*"?(' . $queryIps . ')\s+/i', $sql)) { 
            return $this->_doExec($sql);
        }
        else {
            //��ѯ����
            return $this->_doQuery($sql);
        }
    }
 
    /** 
    * ��ȡ���һ�β�ѯ��sql��� 
    * @return String ִ�е�SQL 
    */ 
    public function getLastSql() { 
        return $this->_sql;
    }
 
    /**
     * ���뷽��
     * @param string $tbName ���������ݱ���
     * @param array $data �ֶ�-ֵ��һά����
     * @return int ��Ӱ�������
     */
    public function insert($tbName,array $data){
        $data = $this->_dataFormat($tbName,$data);
        if (!$data) return;
        $sql = "insert into ".$tbName."(".implode(',',array_keys($data)).") values(".implode(',',array_values($data)).")";
        return $this->_doExec($sql);
    }
 
    /**
     * ɾ������
     * @param string $tbName ���������ݱ���
     * @return int ��Ӱ�������
     */
    public function delete($tbName) {
        //��ȫ����,��ֹȫ��ɾ��
        if (!trim($this->_where)) return false;
        $sql = "delete from ".$tbName." ".$this->_where;
        $this->_clear = 1;
        $this->_clear();
        return $this->_doExec($sql);
    }
  
    /**
     * ���º���
     * @param string $tbName ���������ݱ���
     * @param array $data ��������
     * @return int ��Ӱ�������
     */
    public function update($tbName,array $data) {
        //��ȫ����,��ֹȫ������
        if (!trim($this->_where)) return false;
        $data = $this->_dataFormat($tbName,$data);
        if (!$data) return;
        $valArr = '';
        foreach($data as $k=>$v){
            $valArr[] = $k.'='.$v;
        }
        $valStr = implode(',', $valArr);
        $sql = "update ".trim($tbName)." set ".trim($valStr)." ".trim($this->_where);
        return $this->_doExec($sql);
    }
  
    /**
     * ��ѯ����
     * @param string $tbName ���������ݱ���
     * @return array �����
     */
    public function select($tbName='') {
        $sql = "select ".trim($this->_field)." from ".$tbName." ".trim($this->_where)." ".trim($this->_order)." ".trim($this->_limit);
        $this->_clear = 1;
        $this->_clear();
        return $this->_doQuery(trim($sql));
    }
  
    /**
     * @param mixed $option ��������Ķ�ά���飬����$option['field1'] = array(1,'=>','or')
     * @return $this
     */
    public function where($option) {
        if ($this->_clear>0) $this->_clear();
        $this->_where = ' where ';
        $logic = 'and';
        if (is_string($option)) {
            $this->_where .= $option;
        }
        elseif (is_array($option)) {
            foreach($option as $k=>$v) {
                if (is_array($v)) {
                    $relative = isset($v[1]) ? $v[1] : '=';
                    $logic    = isset($v[2]) ? $v[2] : 'and';
                    $condition = ' ('.$this->_addChar($k).' '.$relative.' '.$v[0].') ';
                }
                else {
                    $logic = 'and';
                    $condition = ' ('.$this->_addChar($k).'='.$v.') ';
                }
                $this->_where .= isset($mark) ? $logic.$condition : $condition;
                $mark = 1;
            }
        }
        return $this;
    }
  
    /**
     * ��������
     * @param mixed $option ������������ ��:array('sort'=>'desc')
     * @return $this
     */
    public function order($option) {
        if ($this->_clear>0) $this->_clear();
        $this->_order = ' order by ';
        if (is_string($option)) {
            $this->_order .= $option;
        }
        elseif (is_array($option)) {
            foreach($option as $k=>$v){
                $order = $this->_addChar($k).' '.$v;
                $this->_order .= isset($mark) ? ','.$order : $order;
                $mark = 1;
            }
        }
        return $this;
    }
  
    /**
     * ���ò�ѯ������ҳ��
     * @param int $page pageSize��Ϊ��ʱΪҳ��������Ϊ����
     * @param int $pageSize Ϊ�������趨ȡ����������Ϊ�����趨ȡ��������ҳ��
     * @return $this
     */
    public function limit($page,$pageSize=null) {
        if ($this->_clear>0) $this->_clear();
        if ($pageSize===null) {
            $this->_limit = "limit ".$page;
        }
        else {
            $pageval = intval( ($page - 1) * $pageSize);
            $this->_limit = "limit ".$pageval.",".$pageSize;
        }
        return $this;
    }
  
    /**
     * ���ò�ѯ�ֶ�
     * @param mixed $field �ֶ�����
     * @return $this
     */
    public function field($field){
        if ($this->_clear>0) $this->_clear();
        if (is_string($field)) {
            $field = explode(',', $field);
        }
        $nField = array_map(array($this,'_addChar'), $field);
        $this->_field = implode(',', $nField);
        return $this;
    }
  
    /**
     * ������Ǻ���
     */
    protected function _clear() {
        $this->_where = '';
        $this->_order = '';
        $this->_limit = '';
        $this->_field = '*';
        $this->_clear = 0;
    }
  
    /**
     * �ֶ��������
     * @return $this
     */
    public function clearKey() {
        $this->_clear();
        return $this;
    }
 
    /**
    * �������� 
    * @return void 
    */ 
    public function startTrans() { 
        //����rollback ֧�� 
        if ($this->_trans==0) self::$_dbh->beginTransaction();
        $this->_trans++; 
        return; 
    }
     
    /** 
    * ���ڷ��Զ��ύ״̬����Ĳ�ѯ�ύ 
    * @return boolen 
    */
    public function commit() {
        $result = true;
        if ($this->_trans>0) { 
            $result = self::$_dbh->commit(); 
            $this->_trans = 0;
        } 
        return $result;
    }
 
    /** 
    * ����ع� 
    * @return boolen 
    */ 
    public function rollback() {
        $result = true;
        if ($this->_trans>0) {
            $result = self::$_dbh->rollback();
            $this->_trans = 0;
        }
        return $result;
    }
 
    /**
    * �ر�����
    * PHP �ڽű�����ʱ���Զ��ر����ӡ�
    */
    public function close() {
        if (!is_null(self::$_dbh)) self::$_dbh = null;
    }
 
}