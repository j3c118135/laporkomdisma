<?php namespace App\Models;

use CodeIgniter\Model;

class KomdismaModel extends Model{
    protected $table      = 'komdisma';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'id_akun', 'nama','foto'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_komdisma = $this->db->table('komdisma');
    }
        
    public function getAll(){
        $auth = new \IonAuth\Libraries\IonAuth();  
        $builder = $this->tb_komdisma;
        $builder->orderBy('id_akun', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->role = $auth->getUsersGroups($row->id_akun)->getRow()->name;
        endforeach;
        return $query;
    }

    public function getWhere($id){
        $builder = $this->tb_komdisma;
        $builder->where('id', $id);
        $query = $builder->get()->getRow();

        return $query;
    }

    

}