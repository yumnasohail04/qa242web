<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');
//include_once APPPATH . '/modules/outlet/controllers/outlet.php';

class Catagories extends MX_Controller {

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
}

function index() {
$this->manage();
}

function manage() {
///////////////////////For Language///////////////////////////
            $limt=50;
            $where['parent_id'] = 0;
            //////////////////////pagination//////////////////////////////////////
            $this->load->library('pagination');
            $segment = intval($this->uri->segment(5));
           
            $data['query'] = $this->_get_records_by_lang_id($limt, $segment, $where, 'is_default desc, id desc');
            $outlet_id = DEFAULT_OUTLET;
            $data['record'] = $this->_get_where($outlet_id);

            $result = $data['query']->result();
            $data['view_file'] = 'manage';
            $this->load->module('template');
            $this->template->admin($data);
}

function create() {
$update_id = $this->uri->segment(4);
if (is_numeric($update_id) && $update_id != 0) {
$data['catagories'] = $this->_get_data_from_db($update_id);

$where['parent_id'] = $update_id;
$data['subcat_arr']=$this->_get_by_arr_id($where)->result_array();
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
function _get_data_from_post_subcat(){
    $data=array();
    $cat_name = $this->input->post('subcat');
    $cat_ids = $this->input->post('cat_ids');
    $total=count($cat_name);
    for ($i=0; $i < $total ; $i++) {
       $data[$i]['id']=$cat_ids[$i];
       $data[$i]['cat_name']=$cat_name[$i];
    }
    return $data;
}
function submit() {

$update_id = $this->uri->segment(4);
//$lang_id = $this->uri->segment(5);

$data_subcat= $this->_get_data_from_post_subcat();
$data = $this->_get_data_from_post();
if ($update_id && $update_id != 0) {
$where['id'] = $update_id;
$itemInfo = $this->_getItemById($update_id);
$actual_img_old = FCPATH . ACTUAL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
$small_img_old = FCPATH . SMALL_CATAGORIES_IMAGE_PATH . $itemInfo->image;
$medium_img_old = FCPATH . MEDIUM_CATAGORIES_IMAGE_PATH . $itemInfo->image;
$large_img_old = FCPATH . LARGE_CATAGORIES_IMAGE_PATH . $itemInfo->image;
$this->_update($where, $data);
foreach ($data_subcat as $key => $value) {
    $update_data['cat_name']=$value['cat_name'];
    $update_data['parent_id']=$update_id;
   if(!empty($value['id'])){
    
    $this->_update(array('id'=>$value['id']),$update_data);
   }else{
    $this->_insert($update_data);
   }
}
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
foreach ($data_subcat as $key => $value) {
    $update_data['cat_name']=$value['cat_name'];
    $update_data['parent_id']=$id;
  
    $this->_insert($update_data);
   
}
$this->upload_image($id);
$this->session->set_flashdata('message', 'Categories'.' '.DATA_SAVED);
$this->session->set_flashdata('status', 'success');
}
redirect(ADMIN_BASE_URL . 'catagories');

}
////////////////////////////////////////////////////
function load_listing() {
$query = 'catagories';
$data['query'] = $this->_get($query,'id desc');
$this->load->view('catagories_listing',$data);  
}

////////////////////////////////////////////////////
function search_catagory() {
$data = $this->_get_data_from_post_search();
$strSearch = $data['cat_name'];
if (empty($strSearch)) {
$strSearch = $this->uri->segment(5);
$strSearch = str_replace("%20", " ", $strSearch);
}
$where['parent_id'] = 0;

//////////////////////pagination//////////////////////////////////////
$this->load->library('pagination');
$segment = intval($this->uri->segment(6));
$config['base_url'] = ADMIN_BASE_URL . 'catagories/search_catagory/' .  '/' . $strSearch;
$config['total_rows'] = $this->_count_where_search($strSearch, $where);
$config['per_page'] = 20;
$config['uri_segment'] = 6;
$config['full_tag_open'] = '<ul class="pagination genral">';
$config['num_links'] = 20;
$config['full_tag_close'] = '</ul>';
$this->pagination->initialize($config);
$data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////
$data['query'] = $this->_search_catagory($strSearch, 20, $segment, $where, 'cat_name asc');
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
//  $where['lang_id'] = $lang_id;
//////////////////////pagination//////////////////////////////////////
$this->load->library('pagination');
$segment = intval($this->uri->segment(6));
$config['base_url'] = ADMIN_BASE_URL . 'catagories/manage_sub_catagories/' . $parent_id ;
$config['total_rows'] = $this->_count_where_sub_cat($where, 'cat_name asc');
$config['per_page'] = 20;
$config['uri_segment'] = 6;
$config['full_tag_open'] = '<ul class="pagination genral">';
$config['num_links'] = 20;
$config['full_tag_close'] = '</ul>';
$this->pagination->initialize($config);
$data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////
$data['query'] = $this->_get_sub_catagories($where, 'rank asc');

$data['record'] = $this->_get_records($where);
$query = $this->_get_by_arr_id($whereParent, 'id desc');
$data['ParentCatDetails'] = $query->row_array();
$data['ParentId'] = $parent_id;
$data['cat_name'] =  urldecode($name);
//echo "data".print_r($data['cat_name']);exit;
$data['view_file'] = 'manage_sub_catagories';
$this->load->module('template');
$this->template->admin($data);
}

function create_sub_catagories() {

$is_edit = 0;
$parent_id = $this->uri->segment(4);
$where['parent_id'] = $parent_id;
$whereParent['id'] = $parent_id;
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
$url_cat_name = $this->uri->segment(4);
$data = $this->_get_data_from_post();
if ($update_id && $update_id != 0) {
// print_r($url_cat_name); exit;
$where['id'] = $update_id;
$this->_update($where, $data);
               
$this->session->set_flashdata('message', 'Catagories'.' '.DATA_UPDATED);                                      
$this->session->set_flashdata('status', 'success');

}
if (!is_numeric($update_id) || $update_id == 0 || empty($update_id)) {
$id = $this->_insert($data);
$this->session->set_flashdata('message', 'Sub Categories'.' '.DATA_SAVED);
$this->session->set_flashdata('status', 'success');

}
redirect(ADMIN_BASE_URL . 'catagories');

}
function get_data_discount_from_post($update_id){
   
    $outlets=$this->input->post('attribute_name');
    $discount=$this->input->post('attribute_type');
    $total=count($outlets);
    for ($i=0; $i <$total; $i++) { 
       $discount_arr['check_cat_id']=$update_id; 
       $discount_arr['attribute_name']=$outlets[$i];
       $discount_arr['attribute_type']=$discount[$i];
       $data[]=$discount_arr;
    }
    
    return $data;
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
$config['per_page'] = 20;
$config['uri_segment'] = 6;
$config['full_tag_open'] = '<ul class="pagination genral">';
$config['num_links'] = 20;
$config['full_tag_close'] = '</ul>';
$this->pagination->initialize($config);
$data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////
$data['query'] = $this->_search_sub_cat($strSearch, 20, $segment, $where, 'cat_name asc');
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

////////////////////////////////////////////////////////////
$data = $this->_get_data_from_db($cat_id);

$file = $data['image'];
$this->load->helper("file");
if(isset($file) && !empty($file) )
{
unlink('./uploads/catagories/small_images/' . $file);
unlink('./uploads/catagories/medium_images/' . $file);
unlink('./uploads/catagories/large_images/' . $file);
unlink('./uploads/catagories/actual_images/' . $file);
}

$this->_delete_sub_catagories_by_category_id($cat_id);

$where['id'] = $cat_id; 
$result = $this->_delete($where);

//        redirect(ADMIN_BASE_URL.'catagories/manage/');
}

function _delete_sub_catagories_by_category_id($cat_id) {
// Modules::run('items/delete_by_category_id', $cat_id);
$data = array();
$data = $this->_get_data_from_db_by_cat_id($cat_id);
foreach ($data as
$image) {
$file = $image;
$this->load->helper("file");
if(isset($file) && !empty($file) )
{   
unlink('./uploads/catagories/small_images/' . $file);
unlink('./uploads/catagories/medium_images/' . $file);
unlink('./uploads/catagories/large_images/' . $file);
unlink('./uploads/catagories/actual_images/' . $file);
}
}
$where['id'] = $cat_id; 
$where['parent_id'] = $cat_id;
$this->_delete($where);

//redirect(ADMIN_BASE_URL.'catagories/manage_sub_catagories/');
}

function _get_data_from_db_by_cat_id($cat_id) {
//$where['lang_id'] = $lang_id;
$where['parent_id'] = $cat_id;
$query = $this->_get_by_arr_id($where);
$data = array();
foreach ($query->result() as
$row) {
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



function delete_sub_catagories() 
{
$delete_id = $this->input->post('id');
$parent_id = $this->input->post('pid');
$where['id'] = $delete_id;
$this->_delete($where);
$wher['check_cat_id']=$delete_id;
$this->_delete_attributes($wher);
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
function change_footer_panel_pages() {   
$id = $this->input->post('id');
$status = $this->input->post('status');
$where2['show_in_footer'] = 1;
$record = $this->_get_by_arr_id($where2) -> num_rows();

if ($record >= 5 ) {
echo 0;
exit;   
}
if ($status == 1)
$status = 0;
else
$status = 1;
$data = array('show_in_footer' => $status);
$status = $this->_update_id($id, $data);
echo 'ok';
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
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_get_sub_cat_by_id($where);
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
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_get_sub_cats_ajax($cat_id);
$data['query'] = $query;
$this->load->view('sub_cats_ajax', $data);
}

function get_sub_cat_by_id() {
$where = $_POST['lstCatagory'];
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_get_sub_cat_by_id($where);
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
$this->load->model('mdl_catagories');
$resultSubCat = array();
$query = $this->mdl_catagories->_get_sub_cat_by_id($where);
foreach ($query->result() as $catagory) {
$resultSubCat[$catagory->id] = $catagory->cat_name;
}
return $resultSubCat;
}
function _get_footerpanel_categories($show_footer){
$data = $this->_get_cat($show_footer)->result_array();
return $data;
}
///////////// For Admin Panel Category Feature Drop down ///////////////////////////
function get_sub_category_dropdown(){
$row_id = $this->input->post('row_id');
$module = $this->input->post('module');
$select_id = $this->input->post('selected_sub_cat');
$selected_sub_category_id = $select_id;
if(isset($row_id) && !empty($row_id) && isset($module) && !empty($module)){
/*$where['id'] = $row_id;
$res_query = Modules::run($module.'/_get_by_arr_id_', $where);
$this_check =$res_query->sub_category_id;
echo $this_check ;
exit;
$selected_sub_category_id = $res_query->sub_category_id;*/
$select_id = $this->input->post('selected_sub_cat');
$id = $this->input->post('id');
$arrSubCategories = array();
$query3 = Modules::run('catagories/_get_sub_cats_by_id', $id);
foreach ($query3->result() as $sub_category) {
$arrSubCategories[$sub_category->id] = $sub_category->cat_name;
}
}
$id = $this->input->post('id');
$arrSubCategories = array();
$query3 = Modules::run('catagories/_get_sub_cats_by_id', $id);
foreach ($query3->result() as $sub_category) {
$arrSubCategories[$sub_category->id] = $sub_category->cat_name;
}

$html = '';
$html.= '<div class="form-group">';
$options = array('' => 'Select') + $arrSubCategories;
$attribute = array('class' => 'control-label col-md-4');
$html .= form_label('Sub Category<span class="required">*</span>', 'lstRoles', $attribute); 
$html .= '<div class="col-md-8">';
$html .=   form_dropdown('lstCatsub', $options, $selected_sub_category_id,  'class = "form-control select2me" data-placeholder="Select Role...", id="lstCatsub" onchange="get_detail()" required '); 
$html .= '</div>
</div>';
echo $html;
}
///////////// For Admin Panel Category Feature Drop down /////////////////////////
///////////// for Front Page add _Post category sub category ///////////////////////////////////////////   
function get_sub_category_dropdown_add_post(){
$admin =  $this->uri->segment(1);
$row_id = $this->input->post('row_id');
$module = $this->input->post('module');
$select_id = $this->input->post('selected_sub_cat');
$selected_sub_category_id = $select_id;
if(isset($row_id) && !empty($row_id) && isset($module) && !empty($module)){
$where['id'] = $row_id;
if ($module ==="category_feature") 
$res_query=$this->_custom_query('select * from category_feature where id='.$row_id)->row();
else
$res_query = Modules::run($module.'/_get_by_arr_id', $where)->row();

$selected_sub_category_id = $res_query->sub_category_id;
}
$id = $this->input->post('id');
$arrSubCategories = array();
$query3 = Modules::run('catagories/_get_sub_cats_by_id', $id);

foreach ($query3->result() as $sub_category) {
$arrSubCategories[$sub_category->id] = $sub_category->cat_name;
}
$html = '';
$html.= '<div class="form-group form_block col-lg-12" >';
$options = array('' => 'Choose Sub Category') + $arrSubCategories;
$attribute = array('class' => 'control-label col-md-3');
$html .= form_label('<span class="required"></span>', 'lstRoles', $attribute); 
$html .= '<div class="col-md-6">';
$html .=   form_dropdown('lstCatsub', $options, $selected_sub_category_id,  'class="form-control input-lg custom-radius "  data-placeholder="Select Role...", id="lstCatsub" onchange="get_feature()"  data-toggle="tooltip" data-placement="top" title="Select proper sub category for your ad" '); 
$html .= '</div>
</div>';
echo $html;
}
////////////////// 	HELPER FUNCTION /////////////////////////
function _get_cat($order_by='id asc'){
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_get_cat($order_by);
return $query;
}

function _get_cat_board_member($id){
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_cat_board_member($id);  
}

function _get_sub_cat_type_by_id2($where) {
return $this->mdl_catagories->_get_sub_cat_type_by_id($where);
}

function _count_where_search($strSearch, $column) {
$this->load->model('mdl_catagories');
$count = $this->mdl_catagories->_count_where_search($strSearch, $column);
return $count;
}

function _count_where_sub_cat_search($strSearch, $column) {
$this->load->model('mdl_catagories');
$count = $this->mdl_catagories->_count_where_sub_cat_search($strSearch, $column);
return $count;
}

function _search_catagory($strSearch, $limit, $segment, $where, $order) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_search_catagory($strSearch, $limit, $segment, $where, $order);
}

function _search_sub_cat($strSearch, $limit, $segment, $where, $order) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_search_sub_cat($strSearch, $limit, $segment, $where, $order);
}

function _getItemById($id) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_getItemById($id);
}

function _get_data_from_db($update_id) {
$where['id'] = $update_id;
$query = $this->_get_by_arr_id($where);
foreach ($query->result() as $row) {
$data['cat_name'] = $row->cat_name;
$data['is_product'] = $row->is_product;
$data['is_ingredients'] = $row->is_ingredients;
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

$data['cat_name'] = $this->input->post('txtCatName');
$data['image'] = $this->input->post('hdn_image');
$data['parent_id'] = $this->input->post('hdnParentId');
$data['is_product'] = $this->input->post('is_product');
$data['is_ingredients'] = $this->input->post('is_ingredients');
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

function _get_front_home_cats() {
$limit = 3;
$where['parent_id'] = 0;
$where['is_active'] = 1;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_front_home_cats($where, $limit);
}

function _get_front_leftpanel_cats() {
$order_by = 'is_default desc, rank asc';
$where['parent_id'] = 0;
$where['is_active'] = 1;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_front_default_cats() {
$order_by = 'rank desc';
$where['parent_id'] = 0;
$where['is_active'] = 1;
$where['is_home'] = 1;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_sub_cats_by_id($parent_id) {
$order_by = 'rank desc';
$where['parent_id'] = $parent_id;
$where['is_active'] = 1;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_front_leftpanel_cats($where, $order_by);
}

function _get_default_cat() {
$order_by = 'is_default desc';
$where['is_default'] = 1;
$where['is_active'] = 1;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_default_cat($where, $order_by);
}

function _get_cat_details_by_id($parent_id) {
$order_by = 'rank asc';
$where['id'] = $parent_id;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_cat_details_by_slug($url_slug) {
$order_by = 'rank asc';
$where['url_slug'] = $url_slug;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_cat_parent_details($parent_id) {
$order_by = 'rank asc';
$where['id'] = $parent_id;
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_cat_details_by_id($where, $order_by);
}

function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_records_by_lang_id($limit, $offset, $arr_col, $order_by);
}

function _get_records($arr_col) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_records($arr_col);
}

function _get_by_arr_id($arr_col) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_by_arr_id($arr_col);
}

function _get($where, $order_by) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->get($where, $order_by);
return $query;
}

function _get_sub_cat($order_by) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_get_sub_cat($order_by);
return $query;
}

function _get_sub_catagories($arr_col, $order_by) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_sub_catagories($arr_col, $order_by);
}
function _get_sub_catagories_front($arr_col, $order_by) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_sub_catagories_front($arr_col, $order_by);
}

function _get_with_20($limit, $offset, $order_by) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->get_with_20($limit, $offset, $order_by);
return $query;
}

function _get_where($id) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->get_where($id);
return $query;
}

function _get_where_custom($col, $value) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->get_where_custom($col, $value);
return $query;
}

function _set_home($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_set_home($arr_col);
}

function _set_not_home($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_set_not_home($arr_col);
}

function _insert($data) {
//print '<hr>Hello ==> '; print_r($data);print ' <== Hello<hr>';
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_insert($data);
}

function _update_id($id, $data) {

$this->load->model('mdl_catagories');
$this->mdl_catagories->_update_id($id, $data);
}

function _update($arr_col, $data) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_update($arr_col, $data);
}

function _delete($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_delete($arr_col);
}

function _set_default($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_set_default($arr_col);
}

function _set_active($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_set_active($arr_col);
}

function _set_in_active($arr_col) {
$this->load->model('mdl_catagories');
$this->mdl_catagories->_set_in_active($arr_col);
}

function _search_page($strSearch, $limit, $segment, $where, $order) {
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_search_page($strSearch, $limit, $segment, $where, $order);
}

function _count_where($column, $order) {
$this->load->model('mdl_catagories');
$count = $this->mdl_catagories->count_where($column, $order);
return $count;
}

function _count_where_sub_cat($column, $order) {
$this->load->model('mdl_catagories');
$count = $this->mdl_catagories->_count_where_sub_cat($column, $order);
return $count;
}

function _get_max() {
$this->load->model('mdl_catagories');
$max_id = $this->mdl_catagories->get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_catagories');
$query = $this->mdl_catagories->_custom_query($mysql_query);
return $query;
}

function _get_cat_sub_cats_items_count($order_by){
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_cat_sub_cats_items_count($order_by);
}

function _get_sub_cats_with_items_count($cat_id, $order_by){
$this->load->model('mdl_catagories');
return $this->mdl_catagories->_get_sub_cats_with_items_count($cat_id, $order_by);
}
////////////////////////
function _insert_attributes_data($data){
        $this->load->model('mdl_catagories');
       return $this->mdl_catagories->_insert_attributes_data($data);
    }
    function get_discounts_arr_from_db($update_id){
         $this->load->model('mdl_catagories');
       return $this->mdl_catagories->get_discounts_arr_from_db($update_id);
    }
    function delete_org_outlet_db($arr_col){
        $this->load->model('mdl_catagories');
        $this->mdl_catagories->delete_org_outlet_db($arr_col);
    }



    ///////////////////////////
    
function manage_attributes() {

$parent_id = $this->uri->segment(4);
$name = $this->uri->segment(5);
$whereParent['id'] = $parent_id;
$where['check_cat_id'] = $parent_id;

$data['query'] = $this->_get_sub_catagories_attibutes($where, 'id asc');

$query = $this->_get_by_arr_id($whereParent, 'id desc');
$data['ParentCatDetails'] = $query->row_array();
$data['ParentId'] = $parent_id;
$data['cat_name'] =  urldecode($name);
//echo "data".print_r($data['cat_name']);exit;
$data['view_file'] = 'manage_sub_catagories_attributes';
$this->load->module('template');
$this->template->admin($data);
}
function create_sub_catagories_attibutes(){

$is_edit = 0;
$parent_id = $this->uri->segment(4);
$where['parent_id'] = $parent_id;
$whereParent['id'] = $parent_id;
$self_id = $this->uri->segment(5);
$data['cat_name'] = $self_id;
///////////////////////For Language///////////////////////////
$data['query'] = $this->_get_sub_catagories($where, 'rank asc');

$data['record'] = $this->_get_records($where);

$query = $this->_get_by_arr_id($whereParent, 'id desc');

$data['ParentCatDetails'] = $query->row_array();
$data['ParentId'] = $parent_id;


if ($self_id > 0) {
    
$data['catagories'] = $this->_get_data_from_db_attributes($self_id,$parent_id);
//echo "data is".print_r($data['catagories']);exit;

} else {
$data['catagories'] = $this->_get_data_from_post_attributes($parent_id);
}
$data['parent_id'] = $parent_id;
$data['update_id'] = $self_id;


$data['view_file'] = 'create_sub_catagories_attributes';

$this->load->module('template');
$this->template->admin_form($data);
}
function submit_sub_catagories_attributes() {
$update_id = 0;

$update_id = $this->uri->segment(5);
$parent_id = $this->uri->segment(4);
$url_cat_name= $this->uri->segment(6);
$data = $this->_get_data_from_post_attributes($parent_id);
if ($update_id && $update_id != 0) {
// print_r($url_cat_name); exit;
$where['id'] = $update_id;
$this->_update_catagories_attributes($where, $data);
              
$this->session->set_flashdata('message', 'attribute'.' '.DATA_UPDATED);                                      
$this->session->set_flashdata('status', 'success');

}
if (!is_numeric($update_id) || $update_id == 0 || empty($update_id)) {
$id = $this->_insert_attributes_data($data);
$this->session->set_flashdata('message', 'attribute'.' '.DATA_SAVED);
$this->session->set_flashdata('status', 'success');

}
redirect(ADMIN_BASE_URL . 'catagories/manage_attributes/' . $parent_id.'/'.$url_cat_name);

}

function _get_sub_catagories_attibutes($where,$order_by){
      $this->load->model('mdl_catagories');
       return $this->mdl_catagories->_get_sub_catagories_attibutes($where,$order_by);
}
function _get_data_from_post_attributes($check_cat_id){
    $data['check_cat_id']=$check_cat_id; 
    $data['attribute_name']=$this->input->post('attribute_name');
    $data['attribute_type']=$this->input->post('attribute_type');
    $data['possible_answers']=$this->input->post('possible_answer');
    $data['min']=$this->input->post('min_value');
    $data['max']=$this->input->post('max_value');
    $data['target']=$this->input->post('target_value');
    $data['possible_value']=$this->input->post('possible_value');
   
   
    return $data;
}
function _get_data_from_db_attributes($attribute_id,$check_cat_id){
    $where['id']=$attribute_id;
    $where['check_cat_id']=$check_cat_id;
    $result=$this->_get_sub_catagories_attibutes($where,'id asc');
    foreach ($result->result() as $key => $value) {
       $data['attribute_name']= $value->attribute_name;
       $data['attribute_type']= $value->attribute_type;
       $data['possible_answers']=$value->possible_answers;
       $data['possible_value']=$value->possible_value;
       $data['min']=$value->min;
       $data['max']=$value->max;
       $data['target']=$value->target;
    }

    return $data;
}
function _update_catagories_attributes($where,$data){
    $this->load->model('mdl_catagories');
       return $this->mdl_catagories->_update_catagories_attributes($where,$data);

}
function delete_sub_catagories_attributes(){
    $delete_id = $this->input->post('id');
    $parent_id = $this->input->post('pid');
    $where['check_cat_id']=$parent_id;
    $where['id']=$delete_id;
    $this->_delete_attributes($where);
}
function _delete_attributes($where){
    $this->load->model('mdl_catagories');
       return $this->mdl_catagories->_delete_attributes($where);

}
}
