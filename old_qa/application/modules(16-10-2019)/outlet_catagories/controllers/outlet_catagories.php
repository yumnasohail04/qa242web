<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Outlet_catagories extends Outlet {

    function __construct() {
        parent::__construct();
//Modules::run('site_security/is_login');
    }

    function index() {
        $this->manage();
    }


    function manage() {
///////////////////////For Language///////////////////////////
        $where['parent_id'] = 0;
        //$where['outlet_id'] = DEFAULT_OUTLET;
        $query = $this->_get_records_by_lang_idv2($where, 'is_default desc, cat_name asc')->result_array();
        $temp_arr=array();
        if(!empty($query)){
            foreach ($query as $key => $value) {
                 $cat= Modules::run('slider/_get_where_cols',array("parent_id" =>$value['id']),'id desc','catagories','id,cat_name')->result_array();

                 if(!empty($cat))
                    foreach ($cat as $key => $value) {
                       $temp_arr[]=$value;
                    }
                    
            }
        }
    $data['temp_arr']=$temp_arr;
     $data['view_file'] = 'manage';
     $this->load->module('template');
     $this->template->admin($data);
 }
 function load_listing() {
        //$query = 'catagories';
        //$data['query'] = $this->_get($query,'id');
    $where['parent_id'] = 0;
    //$where['outlet_id'] = DEFAULT_OUTLET;
    $data['query'] = $this->_get_records_by_lang_idv2($where, 'is_default desc, cat_name asc');

    $arr_essentials= $this->config->item('Essentials');
    unset( $arr_essentials[PERSON] );
    $data['essentials']=  $arr_essentials;
    $arr_col['outlet_id']=DEFAULT_OUTLET;
    $query =Modules::run('add_on/_get_by_arr_id',$arr_col);      
    $arr_adon=array();
    foreach ($query->result() as $row) {
        $arr_adon[$row->id] = $row->title;
    }
    $data['arr_adon'] = $arr_adon;
    $this->load->view('catagories_listing',$data);  
}


function create() {
    $update_id = $this->uri->segment(4);
    if (is_numeric($update_id) && $update_id != 0) {
        $data['catagories'] = $this->_get_data_from_db($update_id);
    } else {
        $data['catagories'] = $this->_get_data_from_post();
    }
    $data['update_id'] = $update_id;
    $data['view_file'] = 'create';
    for ($i = 1;
        $i <= 30;
        $i++) {
        $resultRank[$i] = $i;
}
$data['rank'] = $resultRank;
$this->load->module('template');
$this->template->admin_form($data);
}

function submit() {
    $update_id = $this->uri->segment(4);
            //$lang_id = $this->uri->segment(5);
    $data = $this->_get_data_from_post();
    if (is_numeric($update_id) && $update_id != 0) {
        $where['id'] = $update_id;
        $itemInfo = $this->_getItemById($update_id);
        $actual_img_old = FCPATH . ACTUAL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
        $small_img_old = FCPATH . SMALL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
        $medium_img_old = FCPATH . MEDIUM_CATAGORIES_IMAGE_PATH . $itemInfo->image;
        $large_img_old = FCPATH . LARGE_CATAGORIES_IMAGE_PATH . $itemInfo->image;
        $this->_update($where, $data);
        if (isset($_FILES['catagories_file']['name']) && $_FILES['catagories_file']['name'] != '') {
            if (file_exists($actual_img_old))
                unlink($actual_img_old);
            if (file_exists($small_img_old))
                unlink($small_img_old);
            if (file_exists($medium_img_old))
                unlink($medium_img_old);
            if (file_exists($large_img_old))
                unlink($large_img_old);
            $this->upload_image($update_id);
        }
        $this->session->set_flashdata('message', 'Catagories'.' '.DATA_UPDATED);                                      
        $this->session->set_flashdata('status', 'success');
    }
    if ($update_id == 0) {
        $id = $this->_insert($data);
        $this->upload_image($id);
        $this->session->set_flashdata('message', 'Categories'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
    }
    redirect(ADMIN_BASE_URL . 'catagories');

}

function search_catagory() {
    $data = $this->_get_data_from_post_search();
    $strSearch = $data['cat_name'];
    if (empty($strSearch)) {
        $strSearch = $this->uri->segment(5);
        $strSearch = str_replace("%20", " ", $strSearch);
    }
      //  $lang_id = DEFAULT_LANG;
       // $where['lang_id'] = $lang_id;
    $where['parent_id'] = 0;
//////////////////////pagination//////////////////////////////////////
    $this->load->library('pagination');
    $segment = intval($this->uri->segment(6));
    $config['base_url'] = ADMIN_BASE_URL . 'catagories/search_catagory/' .  '/' . $strSearch;
    $config['total_rows'] = $this->_count_where_search($strSearch, $where);
    $config['per_page'] = LIMIT;
    $config['uri_segment'] = 6;
    $config['full_tag_open'] = '<ul class="pagination genral">';
    $config['num_links'] = NUM_LINKS;
    $config['full_tag_close'] = '</ul>';
    $this->pagination->initialize($config);
    $data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////
    $data['query'] = $this->_search_catagory($strSearch, LIMIT, $segment, $where, 'cat_name asc');
    $data['strSearch'] = $strSearch;
    $data['view_file'] = 'manage';
    $this->load->module('template');
    $this->template->admin($data);
}

function sub_details() {
    $update_id = $this->input->post('id');
    $data['cat_details'] = $this->_get_data_from_db($update_id);
    $data['update_id'] = $update_id;
    $this->load->view('sub_cat_details', $data);
}
 /////////////// for detail ////////////
function detail() {
    $update_id = $this->input->post('id');
    $data['cat_details'] = $this->_get_data_from_db($update_id);
    $data['update_id'] = $update_id;
    //print_r($data);exit();
    $this->load->view('detail', $data);
}

////////////////////////////////////////////////
function manage_sub_catagories() {
    $parent_id = $this->uri->segment(4);
    $name = $this->uri->segment(5);
    $whereParent['id'] = $parent_id;
    $where['parent_id'] = $parent_id;
    $data['query'] = $this->_get_sub_catagories($where, 'rank asc');
    $data['record'] = $this->_get_records($where);
    $query = $this->_get_by_arr_id($whereParent, 'id desc');
    $data['ParentCatDetails'] = $query->row_array();
    $data['ParentId'] = $parent_id;
    $data['cat_name'] = $name;
		/////////////////////////////////////
    $arr_col['outlet_id']=DEFAULT_OUTLET;
    $query =Modules::run('add_on/_get_by_arr_id',$arr_col);
		//$query = $this->_get_by_arr_id($where);
    $arr_adon=array();
    foreach ($query->result() as $row) {
     $arr_adon[$row->id] = $row->title;
 }
 $data['arr_adon'] = $arr_adon;
		/////////////////////////////////////////
 $data['view_file'] = 'manage_sub_catagories';
 $this->load->module('template');
 $this->template->admin($data);
}

function create_sub_catagories() {

    $is_edit = 0;
    $parent_id = $this->uri->segment(4);
      //  echo $parent_id; exit;
    $where['parent_id'] = $parent_id;
    $whereParent['id'] = $parent_id;
        //$lang_id = $this->uri->segment(5);
    $self_id = $this->uri->segment(5);
    $data['cat_name'] = $self_id;
///////////////////////For Language///////////////////////////
    $data['query'] = $this->_get_sub_catagories($where, 'rank asc');
    $data['record'] = $this->_get_records($where);
    $query = $this->_get_by_arr_id($whereParent, 'id desc');
    $data['ParentCatDetails'] = $query->row_array();
    $data['ParentId'] = $parent_id;
    if ($self_id > 0) {
        $data['catagories'] = $this->_get_data_from_db($self_id);
			//echo "data is".print_r($data['catagories']);exit;
    } else {
        $data['catagories'] = $this->_get_data_from_post();
    }
    $data['parent_id'] = $parent_id;
    $data['update_id'] = $self_id;
    $data['view_file'] = 'create_sub_catagories';
    for ($i = 1;
        $i <= 30;
        $i++) {
        $resultRank[$i] = $i;
}
$data['rank'] = $resultRank;
$this->load->module('template');
$this->template->admin_form($data);
}

function submit_sub_catagories() {
    $update_id = 0;
    $update_id = $this->uri->segment(5);
            //$lang_id = $this->uri->segment(5);
    $data = $this->_get_data_from_post();
			//echo "Data".print_r($data);exit;
    if($data['parent_id']==15)
        $data['is_blog'] = 1;
    if (is_numeric($update_id) && $update_id != 0) {
       $where['id'] = $update_id;

       $itemInfo = $this->_getItemById($update_id);
       $actual_img_old = FCPATH . ACTUAL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
       $small_img_old = FCPATH . SMALL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
       $medium_img_old = FCPATH . MEDIUM_CATAGORIES_IMAGE_PATH . $itemInfo->image;
       $large_img_old = FCPATH . LARGE_CATAGORIES_IMAGE_PATH . $itemInfo->image;

       $this->_update($where, $data);
       if (isset($_FILES['catagories_file']['name']) && $_FILES['catagories_file']['name'] != '') {
        if (file_exists($actual_img_old))
            unlink($actual_img_old);
        if (file_exists($small_img_old))
            unlink($small_img_old);
        if (file_exists($medium_img_old))
            unlink($medium_img_old);
        if (file_exists($large_img_old))
            unlink($large_img_old);
        $this->upload_image($update_id);
    }
    $this->session->set_flashdata('message', 'Sub Catagories'.' '.DATA_UPDATED);                                      
    $this->session->set_flashdata('status', 'success');
}
if (!is_numeric($update_id) || $update_id == 0 || empty($update_id)) {
   $id = $this->_insert($data);
   $this->upload_image($id);
   $this->session->set_flashdata('message', 'Sub Categories'.' '.DATA_SAVED);
   $this->session->set_flashdata('status', 'success');
}
redirect(ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $data['parent_id']);

}

function search_sub_cat() {
    $data = $this->_get_data_from_post_search_sub_cat();
    $strSearch = $data['cat_name'];
    if (empty($strSearch)) {
        $strSearch = $this->uri->segment(5);
        $strSearch = str_replace("%20", " ", $strSearch);
    }
      //  $lang_id = DEFAULT_LANG;
      //  $where['lang_id'] = $lang_id;
    $parent_id = $this->uri->segment(4);
    $whereParent['id'] = $parent_id;
    $where['parent_id'] = $parent_id;
//////////////////////pagination//////////////////////////////////////
    $this->load->library('pagination');
    $segment = intval($this->uri->segment(6));
    $config['base_url'] = ADMIN_BASE_URL . 'catagories/search_sub_cat/' . '/' . $strSearch;
    $config['total_rows'] = $this->_count_where_sub_cat_search($strSearch, $where);
    $config['per_page'] = LIMIT;
    $config['uri_segment'] = 6;
    $config['full_tag_open'] = '<ul class="pagination genral">';
    $config['num_links'] = NUM_LINKS;
    $config['full_tag_close'] = '</ul>';
    $this->pagination->initialize($config);
    $data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////
    $data['query'] = $this->_search_sub_cat($strSearch, LIMIT, $segment, $where, 'cat_name asc');
    $query = $this->_get_by_arr_id($whereParent, 'id desc');
    $data['ParentCatDetails'] = $query->row_array();
    $data['strSearch'] = $strSearch;
    $data['ParentId'] = $parent_id;
    $data['view_file'] = 'manage_sub_catagories';
    $this->load->module('template');
    $this->template->admin($data);
}


function delete() {
    $cat_id = $this->input->post('id');
    $arrwhere['category_id'] = $cat_id;
    $in_order_detail = Modules::run('orders/_count_where_order_detail', $arrwhere);
    if($in_order_detail > 0){
        echo '3';
        exit();
    }else{
        $in_product = Modules::run('product/_count_where_arr', $arrwhere);
        if ($in_product > 0 ){
            echo '2';
            exit();
        }
    }

    $data = $this->_get_data_from_db($cat_id);
    $file = $data['image'];

    if(isset($file) && !empty($file) )
    {
        unlink('./uploads/catagories/small_images/' . $file);
        unlink('./uploads/catagories/medium_images/' . $file);
        unlink('./uploads/catagories/large_images/' . $file);
        unlink('./uploads/catagories/actual_images/' . $file);
    }

    // $this->_delete_sub_catagories_by_category_id($cat_id);

    // $where['id'] = $cat_id; 
    $result = $this->_delete($cat_id);
    echo '1';
}

function _delete_sub_catagories_by_category_id($cat_id) {
    $data = array();
    $data = $this->_get_data_from_db_by_cat_id($cat_id);
    foreach ($data as $image) {
        $file = $image;
        if(isset($file) && !empty($file))
        {   
            unlink('./uploads/catagories/small_images/' . $file);
            unlink('./uploads/catagories/medium_images/' . $file);
            unlink('./uploads/catagories/large_images/' . $file);
            unlink('./uploads/catagories/actual_images/' . $file);
        }
    }
    // $where['id'] = $cat_id; 
    // var_dump($where);
    $where['parent_id'] = $cat_id;
    $this->_delete($where);

}

function _get_data_from_db_by_cat_id($cat_id) {
    $where['parent_id'] = $cat_id;
    $query = $this->_get_by_arr_id($where);
    $data = array();
    foreach ($query->result() as $row) {
        $data[] = $row->image;
    }
    return $data;
}

function _get_cat_name_from_db_by_cat_id($cat_id) {
    $where['parent_id'] = $cat_id;
    $query = $this->_get_by_arr_id($where);
    foreach ($query->result() as $row) {
        $data[$row->url_slug] = $row->cat_name;
    }
    return $data;
}



function delete_sub_catagories() {
    $delete_id = $this->input->post('id');
    $parent_id = $this->input->post('pid');
      //  $delete_id = $this->uri->segment(3);
       // $lang_id = $this->uri->segment(5);
       // $parent_id = $this->uri->segment(5);
        //echo "Here issssss".$delete_id.'id'.$parent_id; exit();
    Modules::run('items/delete_by_sub_category_id', $delete_id, $parent_id);
    $data = $this->_get_data_from_db($delete_id);
    $file = $data['image'];
    $this->load->helper("file");
    unlink('./uploads/catagories/small_images/' . $file);
    unlink('./uploads/catagories/medium_images/' . $file);
    unlink('./uploads/catagories/large_images/' . $file);
    unlink('./uploads/catagories/actual_images/' . $file);
    $where['id'] = $delete_id;
       // $where['lang_id'] = $lang_id;
    $this->_delete($where);
    $this->session->set_flashdata('message', 'Sub-Category and Sub-Category items deleted successfully.');
    redirect(ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $parent_id );
}

function set_default() {
    $update_id = $this->uri->segment(4);
       // $lang_id = $this->uri->segment(5);
    $where['id'] = $update_id;
    $arr_sub_cats = Modules::run('catagories/_get_sub_cats_by_id', $update_id);
    if ($arr_sub_cats->num_rows() > 0) {
        $this->_set_default($where);
        $this->session->set_flashdata('message', 'Category set default successfully.');
    } else {
        $this->session->set_flashdata('warning', 'This Category does not have sub-category and cannot be set for default.');
    }
    redirect(ADMIN_BASE_URL . 'catagories/manage/'  . '');
}
function change_status_category() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    if ($status == 1)
        $status = 0;
    else
        $status = 1;
    $data = array('is_active' => $status);
    $status = $this->_update_id($id, $data);
    echo $status;
    exit;
}

function update_cat_essentials(){
    $cat_id['id'] = $this->input->post('cat_id');
    $data['size_group'] = $this->input->post('essentials_id');
    $status = $this->_update_id($cat_id['id'] , $data);
    echo $status;

}
function update_prod_add_on(){
  $prod_id['id'] = $this->input->post('cat_id');
  $data['add_on_id'] = $this->input->post('add_on_id');
  $status = $this->_update_id($prod_id['id'] , $data);
  echo $status;

}

function change_status_sub_category() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    if ($status == 1)
        $status = 0;
    else
        $status = 1;
    $data = array('is_active' => $status);
    $status = $this->_update_id($id, $data);
    echo $status;
    exit;
}
//function set_home_category(){
//	$update_id = $this->uri->segment(4);
//	$lang_id = $this->uri->segment(5);
//	$where['id'] = $update_id;
//        $col = 'is_home';
//        $value= '1';
//       $record =  $this->_get_where_custom($col, $value);
//       if( $record->num_rows < 9){
//	  		$arr_sub_cats = Modules::run('catagories/_get_sub_cats_by_id', $update_id);
//			$arr_sub_cats_items = Modules::run('items/_get_item_from_db_by_cat_id', $update_id,DEFAULT_LANG);
//		if($arr_sub_cats_items->num_rows() > 0){
//		   if($arr_sub_cats->num_rows() > 0){
//           		$this->_set_home($where);
//				$this->session->set_flashdata('message','Category displayed on home page successfully.');
//		   }
//		}
//		else{
//           		$this->session->set_flashdata('warning','This Category does not have sub-category and cannot be set for home page.');
//       	}
//       }else{
//           $this->session->set_flashdata('warning','More than 9 Categories cannot be set for home page.');
//       }
//	redirect(ADMIN_BASE_URL.'catagories/manage/'.$lang_id.'');
//	}
function set_home_category() {
    $update_id = $this->input->post('id');
        //$lang_id = $this->uri->segment(5);
    $status = $this->input->post('status');
    $where['id'] = $update_id;
    $col = 'is_home';
    if ($status == 1)
        $value = 0;
    else
        $value = 1;
    if ($value == 0) {
        $where['id'] = $update_id;
        $this->_set_not_home($where);
        echo 'done';
        exit;
    }

    $record = $this->_get_where_custom($col, $value);
    if ($record->num_rows < 9) {
        $arr_sub_cats = Modules::run('catagories/_get_sub_cats_by_id', $update_id);
        $arr_sub_cats_items = Modules::run('items/_get_item_from_db_by_cat_id', $update_id, DEFAULT_LANG);
        if ($arr_sub_cats_items->num_rows() > 0) {
            if ($arr_sub_cats->num_rows() > 0) {
                $this->_set_home($where);
                echo "done";
                exit;
//				$this->session->set_flashdata('message','Category displayed on home page successfully.');
            }
        } else {
            echo "no";
            exit;
//           		$this->session->set_flashdata('warning','This Category does not have sub-category and cannot be set for home page.');
        }
    } else {
        echo "more";
        exit;
            // $this->session->set_flashdata('warning','More than 9 Categories cannot be set for home page.');
    }
    redirect(ADMIN_BASE_URL . 'catagories/manage/' . '');
}
function set_multi() {
    $data = $this->_get_data_from_post_multi();
    foreach ($data['id'] as
        $key =>
        $id) {
        $update_id = $id;
    $where['id'] = $update_id;
    if (isset($data['btn_publish']) && $data['btn_publish'] == 'Publish')
        $this->_set_active($where);
    elseif (isset($data['btn_unpublish']) && $data['btn_unpublish'] == 'UnPublish')
        $this->_set_in_active($where);
    elseif (isset($data['btn_delete']) && $data['btn_delete'] == 'Delete')
        $this->_delete($where);
}
redirect(ADMIN_BASE_URL . 'catagories');
}

function set_multi_sub_cat() {
    $data = $this->_get_data_from_post_multi();
    $parent_id = $data['parent_id'];
       // $lang_id = $data['lang_id'];
    foreach ($data['id'] as
        $key =>
        $id) {
        $update_id = $id;
    $where['id'] = $update_id;
    if (isset($data['btn_publish']) && $data['btn_publish'] == 'Publish')
        $this->_set_active($where);
    elseif (isset($data['btn_unpublish']) && $data['btn_unpublish'] == 'UnPublish')
        $this->_set_in_active($where);
    elseif (isset($data['btn_delete']) && $data['btn_delete'] == 'Delete')
        $this->_delete($where);
}
redirect(ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $parent_id );
}

/////////////////////////Image Upload//////////////////////////////
function upload_image($nId) {
    $upload_image_file = $this->input->post('hdn_image');
    $upload_image_file = str_replace(' ', '_', $upload_image_file);
    $file_name = 'post_' . $nId . '_' . $upload_image_file;
    $config['upload_path'] = ACTUAL_CATAGORIES_IMAGE_PATH;
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '20000';
    $config['max_width'] = '0';
    $config['max_height'] = '0';
    $config['file_name'] = $file_name;
    $this->load->library('upload');
    $this->upload->initialize($config);
        //delete existing image
//      print_r($config);
//      print_r($_FILES['news_file']);
//      exit;
    if (isset($_FILES['catagories_file'])) {
        $this->upload->do_upload('catagories_file');
    }
    $upload_data = $this->upload->data();

        /////////////// Large Image ////////////////
    $config['source_image'] = $upload_data['full_path'];
    $config['image_library'] = 'gd2';
    $config['maintain_ratio'] = true;
    $config['width'] = 500;
    $config['height'] = 400;
    $config['new_image'] = LARGE_CATAGORIES_IMAGE_PATH;
    $this->load->library('image_lib');
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
    $this->image_lib->clear();

        /////////////  Medium Size /////////////////// 
    $config['source_image'] = $upload_data['full_path'];
    $config['image_library'] = 'gd2';
    $config['maintain_ratio'] = true;
    $config['width'] = 300;
    $config['height'] = 200;
    $config['new_image'] = MEDIUM_CATAGORIES_IMAGE_PATH;
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
    $this->image_lib->clear();

        ////////////////////// Small Size ////////////////
    $config['source_image'] = $upload_data['full_path'];
    $config['image_library'] = 'gd2';
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width'] = 100;
    $config['height'] = 100;
    $config['new_image'] = SMALL_CATAGORIES_IMAGE_PATH;
    $this->image_lib->initialize($config);
    $this->image_lib->resize();
    $this->image_lib->clear();
    $data = array('image' => $file_name);
    $where['id'] = $nId;
    $rsItem = $this->_update($where, $data);
    if ($rsItem)
        return true;
    else
        return false;
}

function delete_images() {
    $file = $this->input->post('image');
    $nId = $this->input->post('id');
    $this->load->helper("file");
    unlink(SMALL_CATAGORIES_IMAGE_PATH . $file);
    unlink(MEDIUM_CATAGORIES_IMAGE_PATH . $file);
    unlink(LARGE_CATAGORIES_IMAGE_PATH . $file);
    unlink(ACTUAL_CATAGORIES_IMAGE_PATH . $file);
    $data = array('image' => "");
    $where['id'] = $nId;
    $this->_update($where, $data);
    return true;
}



function _get_sub_cat_by_id_for_search() {
  echo "here";
  exit;
  $where = $_POST['lstCatagory'];
  $this->load->model('mdl_outlet_catagories');
  $query = $this->mdl_outlet_catagories->_get_sub_cat_by_id($where);
  $resultSubCat = NULL;
  foreach ($query->result() as
    $catagory) {
    $resultSubCat[$catagory->id] = $catagory->cat_name;
}
if ($resultSubCat != NULL) {
    $options = array('' => '---Search by Sub Category--') + $resultSubCat;
    echo form_dropdown('lstSubCatagory', $options, '', 'class = "form-control input-sm" id = "lstSubCatagory"');
} else {
    $options = array('' => '---Search by Sub Category--');
    echo form_dropdown('lstSubCatagory', $options, '', 'class = "form-control input-sm" id = "lstSubCatagory"');
}
}

function get_sub_cats_ajax() {
    $cat_id = $_POST['lstCatagory'];
    if(!is_numeric($cat_id)){
     echo '<option value="" selected="selected">Select</option>';return;
 }
 $this->load->model('mdl_outlet_catagories');
 $query = $this->mdl_outlet_catagories->_get_sub_cats_ajax($cat_id);
 $data['query'] = $query;
 $this->load->view('sub_cats_ajax', $data);
}

function get_sub_cat_by_id() {
    $where = $_POST['lstCatagory'];
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->_get_sub_cat_by_id($where);
    $resultSubCat = NULL;
    foreach ($query->result() as $catagory) {
        $resultSubCat[$catagory->id] = $catagory->cat_name;
    }
    if ($resultSubCat != NULL) {
        $options = array('' => '---select--') + $resultSubCat;
        echo form_label('Sub Category <span class="red" style="color:red;">*</span>', 'lstSubCatagory');
        echo br();
        echo form_dropdown('lstSubCatagory', $options, '', 'class = "form-control validate[required]" id = "lstSubCatagory"');
    } else {
        $options = array('' => '---select--');
        echo form_label('Sub Category <span class="red" style="color:red;">*</span>', 'lstSubCatagory');
        echo br();
        echo form_dropdown('lstSubCatagory', $options, '', 'class = "form-control validate[required]" id = "lstSubCatagory"');
    }
}

function get_sub_cat_by_id_array($where) {
    $this->load->model('mdl_outlet_catagories');
    $resultSubCat = array();
    $query = $this->mdl_outlet_catagories->_get_sub_cat_by_id($where);
    foreach ($query->result() as $catagory) {
        $resultSubCat[$catagory->id] = $catagory->cat_name;
    }
    return $resultSubCat;
}


////////////////// 	HELPER FUNCTION /////////////////////////

function _get_cat_board_member($id){
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_cat_board_member($id);  
}

function _get_sub_cat_type_by_id2($where) {
    return $this->mdl_outlet_catagories->_get_sub_cat_type_by_id($where);
}

function _count_where_search($strSearch, $column) {
    $this->load->model('mdl_outlet_catagories');
    $count = $this->mdl_outlet_catagories->_count_where_search($strSearch, $column);
    return $count;
}

function _count_where_sub_cat_search($strSearch, $column) {
    $this->load->model('mdl_outlet_catagories');
    $count = $this->mdl_outlet_catagories->_count_where_sub_cat_search($strSearch, $column);
    return $count;
}

function _search_catagory($strSearch, $limit, $segment, $where, $order) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_search_catagory($strSearch, $limit, $segment, $where, $order);
}

function _search_sub_cat($strSearch, $limit, $segment, $where, $order) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_search_sub_cat($strSearch, $limit, $segment, $where, $order);
}

function _getItemById($id) {
   $this->load->model('mdl_outlet_catagories');
   return $this->mdl_outlet_catagories->_getItemById($id);
}

function _get_data_from_db($update_id) {
    $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
    $query = $this->_get_by_arr_id($where);
    foreach ($query->result() as $row) {
     $data['meta_description'] = $row->meta_description;
     $data['url_slug'] = $row->url_slug;
     $data['cat_name'] = $row->cat_name;
     $data['rank'] = $row->rank;
     $data['cat_desc'] = $row->cat_desc;
     $data['rank'] = $row->rank;

     $data['image'] = $row->image;
     $data['is_active'] = $row->is_active;
 }
 return $data;
}

function _get_data_from_post_multi() {
    $data['id'] = $this->input->post('chkId');
    $data['parent_id'] = $this->input->post('hdnParentId');
       // $data['lang_id'] = $this->input->post('hdnLangId');
    $data['btn_publish'] = $this->input->post('btnPublish');
    $data['btn_unpublish'] = $this->input->post('btnUnPublish');
    $data['btn_delete'] = $this->input->post('btnDelete');
    return $data;
}

function _get_data_from_post() {
    $page_url = $this->input->post('txtPageUrl');
    $page_title = $this->input->post('txtCatName');
    if (empty($page_url)) {
        $url_slug = $page_title;
        $url_slug = url_title($url_slug, '-', true);
    } else {
        $url_slug = $page_url;
        $url_slug = url_title($url_slug, '-', true);
    }
    $data['url_slug'] = $url_slug;
    $data['meta_description'] = $this->input->post('txtMetaDesc');

    $data['rank'] = $this->input->post('rank');
    $data['cat_name'] = $this->input->post('txtCatName');
    $data['cat_desc'] = $this->input->post('txtCatDesc');
    $data['image'] = $this->input->post('hdn_image');
    $data['parent_id'] = $this->input->post('hdnParentId');
    $data['is_active'] = 1 ;
    $data['outlet_id'] = DEFAULT_OUTLET;
    return $data;
}

function _get_data_from_post_search() {
    $data['cat_name'] = $this->input->post('txtSearch');
      //  $data['lang_id'] = $this->input->post('hdnLangId');
    return $data;
}

function _get_data_from_post_search_sub_cat() {
    $data['cat_name'] = $this->input->post('txtSearch');
       // $data['lang_id'] = $this->input->post('hdnLangId');
    $data['parent_id'] = $this->input->post('hdnParentId');
    return $data;
}

function _get_cats_with_count($outlet_id){
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_cats_with_count($outlet_id);
}

function _get_front_home_cats() {
    $limit = 3;
    $where['parent_id'] = 0;
    $where['is_active'] = 1;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_front_home_cats($where, $limit);
}

function _get_front_leftpanel_cats() {
    $order_by = 'is_default desc, rank asc';
    $where['parent_id'] = 0;
    $where['is_active'] = 1;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_front_default_cats() {
    $order_by = 'rank desc';
    $where['parent_id'] = 0;
    $where['is_active'] = 1;
    $where['is_home'] = 1;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_sub_cats_by_id($parent_id) {
    $order_by = 'rank desc';
    $where['parent_id'] = $parent_id;
    $where['is_active'] = 1;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_default_cat() {
    $order_by = 'is_default desc';
    $where['is_default'] = 1;
    $where['is_active'] = 1;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_default_cat($where, $order_by);
}

function _get_cat_details_by_id($parent_id) {
    $order_by = 'rank asc';
    $where['id'] = $parent_id;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_cat_details_by_slug($url_slug) {
    $order_by = 'rank asc';
    $where['url_slug'] = $url_slug;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_cat_parent_details($parent_id) {
    $order_by = 'rank asc';
    $where['id'] = $parent_id;
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_records_by_lang_id($limit, $offset, $arr_col, $order_by);
}

function _get_records_by_lang_idv2($arr_col, $order_by) {

    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_records_by_lang_idv2($arr_col, $order_by);
}


function _get_records($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_records($arr_col);
}

function _get_by_arr_id($arr_col,$call_by) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_by_arr_id($arr_col,$call_by);
}

function _get($where, $order_by) {
  $this->load->model('mdl_outlet_catagories');
  $query = $this->mdl_outlet_catagories->get($where, $order_by);
  return $query;
}

function _get_sub_cat($order_by) {
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->_get_sub_cat($order_by);
    return $query;
}

function _get_sub_catagories($arr_col, $order_by) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_get_sub_catagories($arr_col, $order_by);
}

function _get_with_limit($limit, $offset, $order_by) {
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->get_with_limit($limit, $offset, $order_by);
    return $query;
}

function _get_where($id) {
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->get_where($id);
    return $query;
}

function _get_where_custom($col, $value) {
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->get_where_custom($col, $value);
    return $query;
}

function _set_home($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_set_home($arr_col);
}

function _set_not_home($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_set_not_home($arr_col);
}

function _insert($data) {
        //print '<hr>Hello ==> '; print_r($data);print ' <== Hello<hr>';
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_insert($data);
}

function _update_id($id, $data) {

    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_update_id($id, $data);
}

function _update($arr_col, $data) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_update($arr_col, $data);
}

function _delete($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_delete($arr_col);
}

function _set_default($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_set_default($arr_col);
}

function _set_active($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_set_active($arr_col);
}

function _set_in_active($arr_col) {
    $this->load->model('mdl_outlet_catagories');
    $this->mdl_outlet_catagories->_set_in_active($arr_col);
}

function _search_page($strSearch, $limit, $segment, $where, $order) {
    $this->load->model('mdl_outlet_catagories');
    return $this->mdl_outlet_catagories->_search_page($strSearch, $limit, $segment, $where, $order);
}

function _count_where($column, $order) {
    $this->load->model('mdl_outlet_catagories');
    $count = $this->mdl_outlet_catagories->count_where($column, $order);
    return $count;
}

function _count_where_sub_cat($column, $order) {
    $this->load->model('mdl_outlet_catagories');
    $count = $this->mdl_outlet_catagories->_count_where_sub_cat($column, $order);
    return $count;
}

function _get_max() {
    $this->load->model('mdl_outlet_catagories');
    $max_id = $this->mdl_outlet_catagories->get_max();
    return $max_id;
}

function _custom_query($mysql_query) {
    $this->load->model('mdl_outlet_catagories');
    $query = $this->mdl_outlet_catagories->_custom_query($mysql_query);
    return $query;
}

function _get_menu_products($where, $product_name, $outlet_id){
  $this->load->model('mdl_outlet_catagories');
  $query = $this->mdl_outlet_catagories->_get_menu_products($where, $product_name, $outlet_id);
  return $query;
}

function _get_price_range($where,$outlet_id){
  $this->load->model('mdl_outlet_catagories');
  $query = $this->mdl_outlet_catagories->_get_price_range($where,$outlet_id);
  return $query;
}
    ///////////////////////////umar apis start/////////////////////////
    function _get_product_detail_with_min_value($where, $product_name, $outlet_id,$select){
      $this->load->model('mdl_outlet_catagories');
      $query = $this->mdl_outlet_catagories->_get_product_detail_with_min_value($where, $product_name, $outlet_id,$select);
      return $query;
    }
    function _get_by_arr_id_back($arr_col) {
        $this->load->model('mdl_outlet_catagories');
        return $this->mdl_outlet_catagories->_get_by_arr_id_back($arr_col);
    }

///////////////////////////end umar apis/////////////////////////
}