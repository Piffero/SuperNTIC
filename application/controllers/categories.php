<?php
require_once ("secure_area.php");

class Categories extends Secure_area
{

    function __construct()
    {
        parent::__construct('categories');
    }

    function index($manage_result = null)
    {
        $data['manage_result'] = $manage_result;
        $data['controller_name'] = 'categories';
        $data['num_row'] = 'CATEGORIAS REGISTRADAS <strong><font color="green">' . $this->Category->count_all() . '</font></strong>';
        $data['manage_table'] = get_category_manage_table($this->Category->get_all(), $this);
        $this->load->view('categories/categories', $data);
    }

    function append($Categorys_id = -1)
    {
        if ($this->check_action_permission('add_update')) {
            $data['categories_info'] = $this->Category->get_info($Categorys_id);
            $this->load->view('categories/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Retorna linhas de dados da tabela cliente. Este ser� chamado com AJAX.
     */
    function search()
    {
        if ($this->check_action_permission('search')) {
            $search = $this->input->post('search');
            $data_rows = get_category_manage_table($this->Category->search($search), $this);
            
            $data['num_row'] = 'CATEGORIAS REGISTRADAS <strong><font color="green">' . $this->Category->count_all() . '</font></strong>';
            $data['controller_name'] = 'Categories';
            $data['manage_table'] = $data_rows;
            $this->load->view('categories/categories', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Gives search suggestions based on what is being searched for
     */
    function suggest()
    {
        $suggestions = $this->Category->get_search_suggestions($this->input->post('q'), $this->input->post('limit'));
        echo implode("\n", $suggestions);
    }
    
    /*
     * Loads the Category edit form
     */
    function view($Categorys_id = -1, $manage_result = null)
    {
        if ($this->check_action_permission('add_update')) {
            $data['manage_result'] = $manage_result;
            $data['id'] = $Categorys_id;
            $data['categories_info'] = $this->Category->get_info($Categorys_id);
            $this->load->view('categories/append', $data);
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
    
    /*
     * Inserts/updates a Category
     */
    function save($categories_id = -1)
    {
        $category_data = array(
            'name' => ucwords(strtolower($this->input->post('name'))),
            'description' => $this->input->post('description')
        );
        
        if ($categories_id) {
            
            // New Category
            if ($categories_id == - 1) {
                $this->Category->save($category_data, $categories_id);
                $this->view($categories_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro inserido com sucesso ' . $category_data['name'] . ' ' . $category_data['description'] . ' ' . $categories_id . '
						</div>');
            } else // previous Category
{
                $this->Category->save($category_data, $categories_id);
                $this->view($categories_id, '
						<div class="alert alert-success">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-check sign"></i><strong>Sucesso!</strong>
						Registro atualizado com sucesso ' . $category_data['name'] . ' ' . $category_data['description'] . ' ' . $categories_id . '
						</div>');
            }
        } else // failure
{
            $this->view($categories_id, '
					<div class="alert alert-danger">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Ocorreu um erro ao inserir ou atualizar o resgistro ' . $category_data['name'] . ' ' . $category_data['description'] . '
					</div>
					');
        }
    }
    
    /*
     * Isso exclui os clientes da tabela de clientes
     */
    function delete($categories_id = -1)
    {
        if ($this->check_action_permission('Delete')) {
            
            $category_to_delete = $categories_id;
            
            if ($this->Category->delete_list($category_to_delete)) {
                
                $this->index('
					<div class="alert alert-info">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-info-circle sign"></i><strong>Erro!</strong>
					Foi Deletado ' . count($category_to_delete) . ' Registro(s).
					</div>
					');
            } else {
                $this->index('
						<div class="alert alert-danger">
						<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
						<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
						Opss.. Ocorreu um erro ao deletar o(s) resgistro(s)
						</div>
						');
            }
        } else {
            $this->index('<div class="alert alert-danger">
					<button class="close" onclick="javascript:window.history.go(-1);" aria-hidden="true" data-dismiss="alert" type="button">x</button>
					<i class="fa fa-times-circle sign"></i><strong>Erro!</strong>
					Opss.. Voc&#234; n&#227;o possui permi&#231;&#227;o para esta a&#231;&#227;o!...
					</div>');
        }
    }
}
?>