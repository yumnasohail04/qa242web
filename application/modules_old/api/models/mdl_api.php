<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_api extends CI_Model {

        function __construct() {
            parent::__construct();
        }
        function get_table() {
            $table = "tablename";
            return $table;
        }
      function get_oultets_from_db($where,$order_by,$user_lat,$user_long,$page_number,$limit,$where_in){
      $offset=($page_number-1)*$limit;
      $table='outlet';
      $this->db->select('outlet.id as outlet_id,outlet.name,outlet.outlet_cover_image as image,outlet.percentage,outlet.image as logo,general_setting.delivery_time,general_setting.discount,AVG(reviews.rating) AS rating,( 6367 * acos( cos( radians('.$user_lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$user_long.') ) + sin( radians('.$user_lat.') ) * sin( radians( latitude ) ) ) ) AS distance');
        $this->db->from($table);
        $this->db->group_by('outlet.id');
        $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
        $this->db->join('reviews','outlet.id=reviews.outlet_id','left'); 
        //$this->db->join('outlet_favourite','outlet.id=outlet_favourite.of_outlet_id','left'); 
        $this->db->order_by($order_by);
        $this->db->where($where);
        if(!empty($where_in))
        $this->db->where_not_in('outlet.id ',$where_in);
          if($limit != 0)
              $this->db->limit($limit, $offset);
        
        return $this->db->get();
    }
         
        function get_ads_outlet_from_db($where,$where_in){
          $table='outlet';
          $this->db->select('outlet.id as outlet_id,outlet.name,outlet.outlet_cover_image as image,outlet.percentage,outlet.image as logo,general_setting.delivery_time,general_setting.discount,AVG(reviews.rating) AS rating,ads_outlet.image ads_image ,general_setting.outlet_slogan ');
            $this->db->from('ads_outlet');
            $this->db->group_by('outlet.id');
            
            $this->db->join($table,'outlet.id=ads_outlet.outlet_id','left');
            $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
            $this->db->join('reviews','outlet.id=reviews.outlet_id','left');
            $this->db->order_by('ads_outlet.page_rank asc');
            $this->db->where($where);
            if(!empty($where_in))
            $this->db->where_not_in('outlet.id ',$where_in);
            $this->db->limit(1);
        return $this->db->get();
       }
        function get_slider_types(){
            $this->db->select('slider.slider_name,slider_types.st_name,slider_types.slider_function');
            $this->db->from('slider');
            $this->db->join('slider_types','slider.slider_type=slider_types.st_id','left');
            $this->db->where('slider.slider_status','Active');
            $this->db->order_by('slider.slider_rank asc');

            $query=$this->db->get();
            return $query;
        }
         function _get_by_arr_id_types_outlets($where){
            $offset=($page_number-1)*$limit;
            $table="outlet_types";
            $this->db->select('outlet_types.id,outlet.type,outlet_types.type_image');
            $this->db->where($where);
             if($limit != 0)
              $this->db->limit($limit, $offset);
            return $this->db->get($table);
        }
        function get_resturant_categories($outlet_id){
            $this->db->select('catagories.cat_name');
            $this->db->from('catagories');
            $this->db->join('outlet_catagories','catagories.id=outlet_catagories.outlet_catagory','left');
            $this->db->where('outlet_catagories.outlet_id',$outlet_id);
            $query=$this->db->get();
            return $query;
      }

    function get_outlet_catagories_db($arr_col) {
        $this->db->select('catagories.cat_name,catagories.id,catagories.icon as image');
        $this->db->from('outlet');
        $this->db->join('outlet_catagories','outlet.id=outlet_catagories.outlet_id','left');
        $this->db->join('catagories','catagories.id=outlet_catagories.outlet_catagory','left');
        $this->db->order_by("id asc");
        $this->db->where($arr_col);
        $query=$this->db->get();
        return $query;
    }
     function _get_offers_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
             $this->db->from('offers');
            $this->db->join('outlet','offers.outlet_id=outlet.id','left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function get_offer_detail_from_db($offer_id,$outlet_id){
            $this->db->select('offers.id as offer_id,offers.start_date,offers.end_date,offers.outlet_id,offers.offer_title,offers.offer_description,offers_products.product_id,offers.start_date,offers.end_date,products.title as product_name,products.description as product_description,products.category_id,products.image as product_image ,MIN(stock.price) as price');
            $product_table=$outlet_id.'_products products';
             $this->db->group_by("products.id");
            $this->db->from('offers');

            $this->db->join('offers_products','offers_products.offer_id=offers.id','left');
            $this->db->join($product_table,'products.id=offers_products.product_id','left');
            $this->db->order_by('offers_products.id asc');
            $this->db->join($outlet_id."_stock stock", "offers_products.product_id = stock.product_id", "left");
            $this->db->where('offers_products.offer_id',$offer_id);
            $query=$this->db->get();
            return $query;
        }
        function get_notifcations_list_from_db($where,$page_number,$limit){
             $offset=($page_number-1)*$limit;
            $this->db->select('app_notifications.id,app_notifications.notifications_title as title,app_notifications.notifications_desc as description,app_notifications.notifications_image as image,notifications_types.notifications_icon as icon,notifications_types.notifications_type');
            $this->db->from('app_notifications');
            $this->db->join('notifications_types','app_notifications.notifications_type=notifications_types.id','left');
           
             if($limit != 0)
              $this->db->limit($limit, $offset);
            $this->db->order_by('app_notifications.id desc');
            $query=$this->db->get();
            return $query;
        }
        function get_latest_notification_count_from_db($user_id){
           $this->db->select('app_notifications.*');
            $this->db->from('app_notifications');
            $this->db->join('notifications_status','app_notifications.id !=notifications_status.notification_id','left');
            $this->db->where('notifications_status.user_id',$user_id);
            $query = $this->db->get();
          return $query;
           
        }
        function get_restaurant_rating($outlet_id){
          $this->db->select('AVG(taste) as taste,AVG(environment) as environment,AVG(behaviour) as behaviour,AVG(responce_time) as responce_time,(AVG(taste)+AVG(responce_time)+AVG(environment)+AVG(behaviour))/4 as total_rating,COUNT(*) as total_reviews');
          $this->db->where('outlet_id',$outlet_id);
          $query = $this->db->get('reviews');
          return $query;
        }
        function _get_restaurant_reviews_list_from_db($where,$page_number,$limit){
             $offset=($page_number-1)*$limit;
            $this->db->select('(taste+environment+responce_time+behaviour)/4 as rating,user_review,customers.name,user_id,reviews.id,reviews.outlet_id');
            $this->db->from('reviews');
            $this->db->group_by('reviews.id');
            $this->db->join('outlet','outlet.id=reviews.outlet_id','left');
            $this->db->join('customers','reviews.user_id=customers.id','left');
            $this->db->order_by('reviews.id desc');
            if($limit != 0)
                $this->db->limit($limit, $offset);
            if(!empty($where))
            $this->db->where($where);
            $query=$this->db->get();
            return $query;
        }
    function get_products_search_by_cat($outlet_arr,$where_produtcs,$like,$order_by,$page_number,$limit) { 
        $union_queries = array();
        $tables = $outlet_arr;
        $offset=($page_number-1)*$limit;
        foreach($tables as $table) {
            $this->db->select($table.'_products.*');
            $this->db->select('catagories.cat_discount');
            $this->db->select('MIN('.$table.'_stock.price) as min_price');
            $this->db->select("outlet.name,outlet.percentage");
            $this->db->select("general_setting.discount");
            $this->db->group_by($table.'_stock.id');
            $this->db->from($table.'_products');
            $this->db->join('catagories',$table.'_products.category_id=catagories.id','left');
            $this->db->join($table.'_stock',$table.'_products.id='.$table
                .'_stock.product_id','left');
            $this->db->join('outlet',$table.'_products.outlet_id=outlet.id','left');
            $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
            $this->db->where('outlet.id',$table);
            $this->db->where('general_setting.outlet_id',$table);
            if(!empty($like)){
                $this->db->or_like($table.'_products.title',$like);
                $this->db->or_like('cat_name',$like);
            }
            $this->db->where('catagories.is_active',1);
            if (!empty($where_produtcs)) 
                $this->db->where($where_produtcs);
            $union_queries[] = $this->db->get_compiled_select();
        }
        $union_query = join(' UNION ALL ',$union_queries); // I use UNION ALL
        if($limit != 0)
        $union_query .= " ORDER BY id asc LIMIT $offset,$limit";
        $outlet_types=$this->db->query($union_query);
        return $outlet_types;
    }
    function get_outlet_facilities($outlet_id) {
        $this->db->select('outlet_features.*');
        $this->db->from('outlet_features');
        $this->db->join('outlet_facilities','outlet_facilities.outlet_id=outlet_features.id','left'); 
        $this->db->where('outlet_facilities.outlet_id',$outlet_id);
        $this->db->order_by('id asc');
        return $this->db->get();
    }
     function get_deals_list_from_db($where,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select('deals.deal_id as deal_id,deals.title ,deals.description,deals.deal_image  as image,deals.amount  as price');
            $this->db->from('deals');
            if($limit != 0)
            $this->db->limit($limit, $offset);
            $this->db->where($where);
            $query=$this->db->get();
            
            return $query;
        }
    function get_deals_detail_db($where){
       
        $this->db->select('deals_products.*,catagories.cat_name');
        $this->db->from('deals_products');
        $this->db->join('catagories','catagories.id=deals_products.catagory_id','left');
        $this->db->where($where);
         return $this->db->get();
    }
    function get_cat_deals_products($outlet_id,$deal_id,$catagory_id,$stock_size){
        $stock_table=$outlet_id.'_stock stock';
        $product_table=$outlet_id.'_products products';
        $this->db->select('stock.id as stock_id,stock.label as stock_label,stock.price as stock_price,products.id as product_id,products.title as product_title,products.category_id');
        $this->db->from($product_table);
        $this->db->group_by('stock.id');
        $this->db->join('deals_products','products.id=deals_products.product_id','left');
        $this->db->join('deals','deals.deal_id=deals_products.deal_id','left');
        $this->db->join($stock_table,'products.id=stock.product_id ','left');
        $this->db->where('products.category_id',$catagory_id);
        $this->db->where('stock.label',$stock_size);
       
         return $this->db->get();
    }
    function get_timelines_list_from_db($where,$page_number,$limit){
        $offset=($page_number-1)*$limit;
        $this->db->select('timelines.id,timelines.notifications_title as title,timelines.notifications_type ,timelines.notifications_desc as description,timelines.notifications_image as image,');
        $this->db->from('timelines');
        if(!empty($where))
            $this->db->where($where);
         if($limit != 0)
          $this->db->limit($limit, $offset);
        $this->db->order_by('timelines.id desc');
        $query=$this->db->get();
        return $query;
    }

        ////////////////////////asad///////////////////
        function get_search_outlet_data($search_text){
          $this->db->select('id, name, address');
          $this->db->like('name', $search_text);
          $query = $this->db->get('outlet');
          return $query;
        }
 
        function get_restaurant_data_from_db(){
            $table="outlet";
            $this->db->select('outlet.id,outlet.image,outlet.name');
            $this->db->where('outlet.status',1);
            return $this->db->get($table);
        }
        function get_outlet_types(){
            $table='outlet_types';
            $this->db->select('id,type as catagory_name');
            return $this->db->get($table);
        }
        ///////////////////////////umar apis start/////////////////////////
         function check_favourite_food($where) {
            $table = 'favourite_food';
            $this->db->where($where);
            return $this->db->get($table);
        } 
        function insert_or_delete($where,$data,$table) {
            $insert_id = 0;
            if(!empty($where))
            $this->db->where($where);
            $query=$this->db->get($table)->num_rows();
            if($query > 0) {
              if(!empty($where))
                $this->db->where($where);
                $this->db->delete($table);
            }
            else {
              $this->db->insert($table, $data);
              $insert_id = $this->db->insert_id();
            }
            return $insert_id; 
        }
        function delete_from_specific_table($where,$table) {
            $this->db->where($where);
            $this->db->delete($table);
        }
        function update_specific_table($where,$data,$table) {
            if(!empty($where))
            $this->db->where($where);
            $this->db->update($table, $data);
        }
        function insert_or_update($where,$data,$table) {
            $insert_id = 0;
            if(!empty($where))
                $this->db->where($where);
            $query=$this->db->get($table)->num_rows();
            if($query > 0) {
              if(!empty($where))
                $this->db->where($where);
                $this->db->update($table, $data);
            }
            else {
              $this->db->insert($table, $data);
              $insert_id = $this->db->insert_id();
            }
            return $insert_id; 
        }
        function _insert_into_specific_table($data,$table){
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
        function insert_or_update_specific_image($where,$data,$table,$index) {
            $inserted_id = array();
            if(!empty($where))
            $this->db->where($where);
            $query=$this->db->get($table);
            $query2=$query->result_array();
            $query=$query->num_rows();
            if($query > 0) {
              if(!empty($where))
                $this->db->where($where);
                $this->db->update($table, $data);
                if(isset($query2[0][$index]) && !empty($query2[0][$index])) {
                    $inserted_id['update_insert'] ="update";
                    $inserted_id['inserted_id'] = $query2[0][$index];
                }
                else {
                    $inserted_id['update_insert'] ="update";
                    $inserted_id['inserted_id'] = '0';
                }
            }
            else {
              $this->db->insert($table, $data);
              $insert_idd = $this->db->insert_id();
              $inserted_id['update_insert'] ="insert";
              $inserted_id['inserted_id'] = $insert_idd;
            }
            if(isset($inserted_id))
              return $inserted_id; 
        }
        function _get_specific_table_with_pagination($cols, $order_by,$table,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        ///////////////////////////umar insights start/////////////////////////
        function get_city_areas($cols, $order_by,$group_by,$select,$page_number,$limit,$or_where,$and_where,$having){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from('city_town');
            $this->db->join('city','city_town.city_town_id=city.city_id','inner');
            $this->db->join('country','city.c_id=country.c_id','inner');
            if(!empty($cols))
                $this->db->where($cols);
            if(!empty($or_where))
                $this->db->where($or_where);
            if(!empty($group_by))
                $this->db->group_by($group_by);
            if(!empty($having))
                $this->db->having($having);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function _get_specific_table_with_pagination_and_where($cols, $order_by,$table,$select,$page_number,$limit,$or_where,$and_where,$having){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            if(!empty($cols))
                $this->db->where($cols);
            if(!empty($or_where))
                $this->db->where($or_where);
            if(!empty($having))
                $this->db->having($having);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function _get_specific_table_with_pagination_where_groupby($cols, $order_by,$group_by,$table,$select,$page_number,$limit,$or_where='',$and_where='',$having=''){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($table);
            if(!empty($group_by))
                $this->db->group_by($group_by);
            if(!empty($cols))
                $this->db->where($cols);
            if(!empty($or_where))
                $this->db->where($or_where);
            if(!empty($and_where))
                $this->db->where($and_where);
            if(!empty($having))
                $this->db->having($having);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        ///////////////////////////umar insights end/////////////////////////
        function get_trending_products_from_db($where,$page_number,$limit){
            $union_queries = array();
            $offset=($page_number-1)*$limit;
            $outlets = Modules::run('api/_get_specific_table_with_pagination',$where,'id desc','outlet','id','1','0')->result_array();
            if(!empty($outlets)) {
                foreach($outlets as $table):
                    $this->db->select($table["id"]."_products.id as product_id,".$table["id"]."_products.outlet_id,count(".$table["id"]."_orders_detail.product_id) as orders,title as name,".$table["id"]."_products.image,".$table["id"]."_products.product_discount,".$table["id"]."_products.category_id as cat_id,name as outlet_name");
                    $this->db->group_by($table["id"]."_products.id");
                    $this->db->from($table['id'].'_products');
                    $this->db->join($table['id'].'_orders_detail',$table['id'].'_products.id='.$table['id'].'_orders_detail.product_id','left');
                    $this->db->join('catagories',$table['id'].'_products.category_id=catagories.id','left');
                    $this->db->join('outlet',$table['id'].'_products.outlet_id=outlet.id','left');
                    $union_queries[] = $this->db->get_compiled_select();
                endforeach;
                $union_query = join(' UNION ALL ',$union_queries); // I use UNION ALL
                if($limit != 0)
                $union_query .= " ORDER BY orders desc LIMIT $offset,$limit";
                $outlet_types=$this->db->query($union_query);
            }
            return $outlet_types;
        }
        function _get_outlet_types($cols, $order_by,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->group_by('outlet_catagories.outlet_catagory,outlet_catagories.outlet_id');
            $this->db->from('outlet_catagories');
            $this->db->join('outlet','outlet_catagories.outlet_id=outlet.id','left');
            $this->db->join('catagories','outlet_catagories.outlet_catagory=catagories.id','left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function _get_user_favourite_products_with_pagination($cols,$select,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->group_by('favourite_food.id');
            $this->db->from('favourite_food');
            $this->db->join('outlet','favourite_food.outlet_id=outlet.id','left');
            $this->db->join('customers','favourite_food.user_id=customers.id','left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->order_by('favourite_food.id');
            $query=$this->db->get();
            return $query;
        }
        function get_catagories_outlets($cols,$select,$order_by,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->group_by('outlet_catagories.outlet_catagory,outlet_catagories.outlet_id');
            $this->db->from('outlet_catagories');
            $this->db->join('outlet','outlet_catagories.outlet_id=outlet.id','left');
            if(!empty($cols))
            $this->db->where($cols);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            if(isset($order_by) && !empty($order_by))
                $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function get_product_add_on_with_add_detail($where,$order_by,$select,$outlet_id,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select($select);
            $this->db->from($outlet_id.'_product_add_ons');
            $this->db->join($outlet_id.'_add_on',$outlet_id.'_product_add_ons.pao_add_on='.$outlet_id.'_add_on.id','left');
            if(!empty($where))
            $this->db->where($where);
            if($limit != 0)
                $this->db->limit($limit, $offset);
            if(isset($order_by) && !empty($order_by))
                $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        function get_outlet_product_max_min_price($where,$outlet_id,$having){
            $this->db->select('outlet.id ,MIN('.$outlet_id.'_stock.price) as min_price,MAX('.$outlet_id.'_stock.price) as max_price');
            $this->db->from('outlet');
            $this->db->group_by('outlet.id');
            $this->db->join($outlet_id.'_products','outlet.id='.$outlet_id.'_products.outlet_id','left');
            $this->db->join($outlet_id.'_stock',$outlet_id.'_products.id='.$outlet_id.'_stock.product_id','left');
            if(!empty($where))
                $this->db->where($where);
            if(!empty($having))
                $this->db->having($having);
            $query=$this->db->get();
            return $query;
        }
        function get_nearest_outlest($where,$like,$order_by){
            $this->db->select('outlet.id ,outlet.name ,outlet.image as logo,outlet.outlet_cover_image as image,outlet.page_rank,general_setting.delivery_time,AVG(reviews.rating) as rating,COUNT(users_orders.outlet_id) as popular,outlet.percentage
,general_setting.discount');
            $this->db->from('outlet');
            $this->db->group_by('outlet.id');
            $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
            $this->db->join('reviews','outlet.id=reviews.outlet_id','left');
            $this->db->join('users_orders','outlet.id=users_orders.outlet_id','left');
            if(isset($where['outlet_catagories.outlet_catagory']) && !empty($where['outlet_catagories.outlet_catagory']))
                $this->db->join('outlet_catagories','outlet.id=outlet_catagories.outlet_id','left');
            if(isset($where) && !empty($order_by))
                $this->db->order_by('delivery_time asc');
            if(isset($like) && !empty($like))
                $this->db->like($like);
            if(isset($where) && !empty($where))
                $this->db->where($where);
            $query=$this->db->get();
            return $query;
        }
         function get_nearest_outlest_search_wise($where,$like,$order_by){
            $result = array();
            $this->db->select('catagories.parent_id');
            $this->db->from('catagories');
            $this->db->like('catagories.cat_name',$like);
            $query=$this->db->get()->result_array();
            if(!empty($query) && !empty($query[0]['parent_id'])){
                $where_in=array_column($query ,'parent_id');
                $this->db->select('outlet.id ,outlet.name ,outlet.image as logo,outlet.outlet_cover_image as image,outlet.page_rank,general_setting.delivery_time,AVG(reviews.rating) as rating,outlet.percentage
,general_setting.discount');
            $this->db->from('outlet');
            $this->db->group_by('outlet.id');
            $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
            $this->db->join('reviews','outlet.id=reviews.outlet_id','left');
            $this->db->join('users_orders','outlet.id=users_orders.outlet_id','left');
            $this->db->join('outlet_catagories','outlet.id=outlet_catagories.outlet_id','left');
            if(isset($where) && !empty($order_by))
                $this->db->order_by('delivery_time asc');
            if(isset($like) && !empty($like))
                $this->db->like($like);
            if(isset($where) && !empty($where))
                $this->db->where($where);
             $this->db->where_in('outlet_catagories.outlet_catagory',$where_in);
            $query=$this->db->get()->result_array();
          
            }

              return $result;
            
        }
       
        function get_specific_table_data($where,$order,$select,$table_name,$page_number,$limit) {
            $offset = ($page_number-1) *$limit;
            $this->db->select($select);
            $this->db->from($table_name);
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($limit) && !empty($limit))
                if($limit !=0)
                    $this->db->limit($limit,$offset);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function get_driver_basic_info($where,$order,$select) {
            if(!isset($select) || empty($select))
                $select='*';
            $this->db->select($select);
            $this->db->from('driver');
            $this->db->group_by('driver.driver_id');
            $this->db->join('country','driver.driver_country=country.c_id','left');
            $this->db->join('city','driver.driver_city=city.city_id','left');
            $this->db->join('city_town','driver.driver_town=city_town.town_id','left');
            $this->db->join('town_postcodes','driver.driver_post_code=town_postcodes.tpc_id','left');
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function get_driver_vehicle_info($where,$order,$select) {
            if(!isset($select) || empty($select))
                $select='*';
            $this->db->select($select);
            $this->db->from('driver_vehicle');
            $this->db->group_by('driver_vehicle.dv_id');
            $this->db->join('driver','driver_vehicle.driver_id=driver.driver_id','left');
            $this->db->join('vehicle_category','driver_vehicle.vehicle_make=vehicle_category.vehicle_cat_id','left');
            $this->db->join('vehicle_model','driver_vehicle.vehicle_model=vehicle_model.vehicle_mod_id','left');
            $this->db->join('vehicle_body','driver_vehicle.vehicle_body=vehicle_body.vehicle_bd_id','left');
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function _get_user_order_list($where,$order,$table_name,$select,$where_status,$page_number,$limit) {
            $offset = ($page_number-1) *$limit;
            $this->db->select($select);
            $this->db->from($table_name);
            $this->db->join('outlet','users_orders.outlet_id=outlet.id','left');
            if(isset($where) && !empty($where))
                $this->db->where($where);
            if(isset($where_status) && !empty($where_status)) {
                foreach ($where_status as $key => $ws) {
                    if($key == 0)
                        $this->db->where($table_name.".order_status",$ws);
                    else
                        $this->db->or_where($table_name.".order_status",$ws);
                }
            }
            if(isset($limit) && !empty($limit))
                if($limit !=0)
                    $this->db->limit($limit,$offset);
            if(isset($order) && !empty($order))
                $this->db->order_by($order);
            return $this->db->get();
        }
        function get_order_items($where, $order_by,$table_name,$group_by,$select){
            $this->db->select($select);
            $this->db->from($table_name);
            if(!empty($group_by))
                $this->db->group_by($group_by);
            if(!empty($where))
            $this->db->where($where);
            $this->db->order_by($order_by);
            $query=$this->db->get();
            return $query;
        }
        ///////////////////////////end umar apis/////////////////////////
        ////////////////////for payment +place order api by asad
         function get_general_setting($outlet_id){
    
          $table="general_setting";
          $this->db->where('outlet_id',$outlet_id);
          //$this->db->where('status',1);
          return $this->db->get($table);
        }
        function insert_user_order_taxes($data,$taxes_table,$outlet_id){
    
          $table=$outlet_id."_".$taxes_table;
          $this->db->insert($table,$data);
          
          return $this->db->insert_id();
        }
        function _insert_user_order_history($data,$outlet_id){
    
          $table="users_orders";
          $this->db->insert($table,$data);
          
          return $this->db->insert_id();
        }
        
        function insert_transaction_detail_db($data){
    
          $table="transaction_detail";
          $this->db->insert($table,$data);
          
          return $this->db->insert_id();
        }
        function get_transaction_detail_db($where){
    
          $table="transaction_detail";
          
          $this->db->where($where);
          
          return $this->db->get($table);
        }
        
         function get_favourite_outlets_db($user_id,$page_number,$limit){
            $offset=($page_number-1)*$limit;
            $this->db->select('outlet.id as id,outlet.name as name,outlet.percentage,outlet.image as logo,outlet.outlet_cover_image as image,outlet.page_rank,general_setting.delivery_time,general_setting.discount,COUNT(outlet_favourite.of_id) as followers,AVG(reviews.rating) as rating');
            $this->db->from('outlet');
            $this->db->group_by('outlet.id');
            $this->db->join('general_setting','outlet.id=general_setting.outlet_id','left');
            $this->db->join('reviews','outlet.id=reviews.outlet_id','left');
            $this->db->join('outlet_favourite','outlet_favourite.of_outlet_id=outlet.id','left');
           
            $this->db->order_by('delivery_time asc');
            if($limit != 0)
                $this->db->limit($limit, $offset);
            $this->db->where('outlet_favourite.of_user_id',$user_id);
            $query=$this->db->get();
            return $query;
        }
       
        
    }
