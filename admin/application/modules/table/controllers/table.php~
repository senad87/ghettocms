<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Table extends MX_Controller {

	function __construct()
	{
		//check_login();
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('table');
	}

	public function index($items, $columns, $module_name, $offset=0, $uri_segment='index'){
		$data['items'] = $items;
		$data['module_name'] = $module_name;
		$columns_data = $this->columns_to_array($columns);
		
		$data['table'] = $columns_data;
		$data['offset'] = $offset;
		$data['link'] = $module_name.'/'.$uri_segment;
		$data['column_count'] = count($columns_data);
		$data['that'] = $this;
		$this->load->view('table_view', $data);	
	}

	public function set_th($column, $module_name, $offset=0, $orderColumn='', $order='', $link){
		
		switch($column['type']){
			case 'input':
			echo '<th class="width_21" scope="col"><input class="checkbox" id="all" type="'.$column['input_type'].'" value=""></th>';
			break;
			case 'text_order':
			case 'date_order':
			if($orderColumn===$column['sql_title']){
				if($order=='desc'){
				echo '<th scope="col"><a class="order_down" href="'.base_url().$link.'/'.$column['sql_title'].'-asc/'.$offset.'/" >'.$column['title'].'</a></th>';
				}else{
				echo '<th scope="col"><a class="order_up" href="'.base_url().$link.'/'.$column['sql_title'].'-desc/'.$offset.'/" >'.$column['title'].'</a></th>';
				}
			}else{
			echo '<th scope="col"><a href="'.base_url().$link.'/'.$column['sql_title'].'-desc/'.$offset.'/" >'.$column['title'].'</a></th>';
			}
			break;
			case 'status':
			echo '<th class="width_21" scope="col">'.$column['title'].'</th>';
			break;
			case 'status_order'://TODO: ove if-ove treba srediti, koristiti kratki oblik, pojednostaviti ovaj deo
			if($orderColumn===$column['sql_title']){
				if($order=='desc'){
				echo '<th class="width_43" scope="col"><a class="order_down" href="'.base_url().$link.'/'.$column['sql_title'].'-asc/'.$offset.'/" >'.$column['title'].'</a></th>';
				}else{
				echo '<th class="width_43" scope="col"><a class="order_up" href="'.base_url().$link.'/'.$column['sql_title'].'-desc/'.$offset.'/" >'.$column['title'].'</a></th>';
				}
			}else{
			echo '<th class="width_43" scope="col"><a href="'.base_url().$link.'/'.$column['sql_title'].'-desc/'.$offset.'/" >'.$column['title'].'</a></th>';
			}
			break;
			default://default is 'text' type
			echo '<th scope="col">'.$column['title'].'</th>';
			break;
		}
	}
	
	public function set_td($column, $data, $module_name, $link){
		switch($column['type']){
			case 'input':
			echo '<td><input class="checkbox" name="row" type="checkbox" value="'.$data['id'].'"></td>';
			break;
			case 'text_link':
			case 'text_link_order':
			echo '<td><a href="'.base_url().$module_name.'/edit/'.$data['id'].'">'.$data[$column['sql_title']].'</a></td>';
			break;
			case 'custom_link':
			echo '<td><a href="'.base_url().$module_name.'/'.$column['url'].'/'.$data['id'].'">'.$data[$column['sql_title']].'</a></td>';
			break;
			case 'status':
			case 'status_order':
			$status_image = $this->status($data[$column['sql_title']]);
			echo '<td class="center_img" ><img src="'.base_url().'application/views/images/'.$status_image.'" /></td>';
			break;
			case 'date':
			case 'date_order':
			echo '<td>'.format_date($data[$column['sql_title']], "date").'</td>';
			break;
			default://default is 'text' type
			echo '<td>'.neat_trim($data[$column['sql_title']], 50).'</td>';
			break;
		}
	
	}
	
	
	private function columns_to_array($columns){
		foreach($columns as $column){
			$item = explode("|", $column);
				foreach($item as $key=>$value){
					switch($key){
						case 0:
						$key = 'type';
						break;
						case 1:
						$key = 'sql_title';
						break;
						case 2:
						$key = 'title';
						break;
						case 3:
						$key = 'input_type';
						break;
						case 4:
						$key = 'url';
						break;
					}
					
					$new_item[$key] = $value;
				}
			
			$columns_data[] = $new_item;	
		}
	
		return $columns_data;
	}
	 
	private function status($status){
		switch($status){
			case '1':
				return "icons/published.png";
			break;
			case '2':
				return "icons/unpublished.png";
			break;
			case 'Submitted':
				return "icons/submitedd.png";
			break;
			case 'In process':
				return "icons/inProcess.png";
			break;
			case 'In delivery':
				return "icons/inDelivery.png";
			break;
			case 'Delivered':
				return "icons/delivered.png";
			break;
		}
	}
	
	
}
/* End of file toolbar.php */
/* Location: ./application/modules/toolbar/controllers/toolbar.php */
