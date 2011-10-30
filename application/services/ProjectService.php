<?php

/**
 * Description of ProjectService
 *
 * @author Jaroslav Gnatjuk
 */

class Service_ProjectService extends Service_BaseService {

    /**
     * Author Zend Table
     * @var AuthorTable
     */
    protected $authorTable;
    
    protected $authorService;

    /**
     * Role Zend Table
     * @var RoleTable
     */
    protected $roleTable;

    /**
     * Project Zend Table
     * @var ProjectTable
     */
    protected $projectTable;

    /**
     * ProjectAuthorRole Zend Table
     * @var ProjectAuthorRoleTable
     */
    protected $projectAuthorRoleTable;

    /**
     * LabWorkType Zend Table
     * @var LabWorkTypeTable
     */
    protected $labWorkTypeTable;

    public function __construct() {
        $this->authorTable = new Model_AuthorTable();
        $this->authorService = new Service_AuthorService();
        $this->roleTable = new Model_RoleTable();
        $this->projectTable = new Model_ProjectTable();
        $this->projectAuthorRoleTable = new Model_ProjectAuthorRoleTable();
        $this->labWorkTypeTable = new Model_LabWorkTypeTable();
    }
    
    public function getProjectById($id) {
        $where = $this->projectTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->projectTable->fetchAll($where)->current()->toArray();
    }
    
    public function getProjectListByLabId($id) {
        $where = $this->projectTable->getAdapter()->quoteInto('lab_id = ?', $id);
        return $this->projectTable->fetchAll($where)->toArray();
    }

    public function getWorkTypeListByLabId($id) {
        $where = $this->labWorkTypeTable->getAdapter()->quoteInto('lab_id = ?', $id);
        return $this->labWorkTypeTable->fetchAll($where)->toArray();
    }
    public function getAuthorAndRoleListByProjectId($id){
        $authorAndRoleIdList = $this->getAuthorAndRoleIdListByProjectId($id);
        $projectTeam = array();
        foreach ($authorAndRoleIdList as $elem) {
            $teamMember = array();
            $teamMember['member'] = $this->authorService->getAuthorById($elem['author_id']);
            $teamMember['role'] = $this->getRoleById($elem['role_id']);
            $projectTeam[] = $teamMember;
        }
        return $projectTeam;
    }
    
    private function getAuthorAndRoleIdListByProjectId($id){
        $where = $this->projectAuthorRoleTable->getAdapter()->quoteInto('project_id = ?', $id);
        return $this->projectAuthorRoleTable->fetchAll($where)->toArray();
    }
    
    
    private function getRoleById($id) {
        $where = $this->roleTable->getAdapter()->quoteInto('id = ?', $id);
        return $this->roleTable->fetchAll($where)->current()->toArray();
    }
}

?>
