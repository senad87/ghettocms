<?php

class Images extends MX_Controller {

	function __construct()
	{
		parent::__construct();	
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('Images_model');
                $this->load->model('Dimensions_model');
		$this->load->library('image_lib');
	}
	
	function index()
	{
		
		$data['images'] = $this->Images_model->getImages();
		//print_r($data['images']);
		$this->load->view('header_view');
		$this->load->view('images_view', $data);
		//$this->load->view('footer_view');
	
	}
	
	function test(){
		$this->load->view('test_view');
	}
	
	function loadEdit(){
		$ids = $this->input->post('ids');
		if($ids != ""){
                    $data['ids'] = implode(',', $ids);
                    $images = array();
                    foreach($ids as $id){
                            $images[] = $this->Images_model->getImage($id);
                    }
                    $data['images'] = $images;
                    $this->load->view('loadEdit_view', $data);
		}
		
		
		
	}
	
	
	public function upload(){
		$uploaddir = '../upload_img';
		//$len = strlen($_FILES['uploadfile']['name']) - 1;
		//$childdir = $uploaddir.substr($_FILES['uploadfile']['name'],0, -$len); //takes first letter from string
		//if(@opendir($childdir) == false){
			//mkdir($childdir);
		//}
		//$filename = explode('.', $_FILES['uploadfile']['name']);
		$file = $uploaddir ."/". uniqid()."-".basename($_FILES['uploadfile']['name']);
		//print_r($_FILES['uploadfile']['error']);
                
		if(!file_exists($file)){ 
                    if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)){ 
				$id = $this->Images_model->insertImage($_FILES['uploadfile']['name'],$tags=$_FILES['uploadfile']['name'], $file);
                                //$file = substr($file, 2);//removes two dot at begging
                                $response = array('id'=>$id, 'filepath'=>$file);

                                header('Content-type: application/json');
                                echo json_encode($response);
			}else{
			 	echo "error";
			}
		}else{
			echo "file_exists";
		
		}
                //print_r(getimagesize($file));
	}
	
	
	//loads java script at the bottom of the page 
	public function script() {
		$data['id'] = $this->input->post('id');
		$data['image'] = $this->input->post('image');
		$this->load->view('script_view', $data);
	}
	
	public function delete(){
	
		$data['id'] = $this->input->post('id');
		//print_r($data['id']);
		$this->Images_model->deleteImage($data['id']);
		//ovde uzmem idijeve, za njih dovucem iz baze putanje i obrisem ih i sa fajl sistema i iz baze
		//$data['image'] = $this->input->post('image');
		//unlink("upload_img/".$data['image']);
	}
	
	public function update(){
		$data['id'] = $this->input->post('id');
		$data['title'] = $this->input->post('title');
		$data['tags'] = $this->input->post('tags');
		$this->Images_model->updateImage($data['id'], $data['title'], $data['tags']);
	}
	
	public function open(){
		$id = $this->uri->segment(3);
		$data['image'] = $this->Images_model->getImage($id);
		$data['image_info'] = getimagesize(root_url().substr($data['image']->path, 2));
		//print_r($data['image_info']);
		$data['width'] = $data['image_info'][0];
		$data['height'] = $data['image_info'][1];
		//print_r($data);die;
		$this->load->view('crop_view', $data);
	}
	
	public function crop(){
			$uploaddir = '../upload_img';
			$src = substr($this->input->post('src'), 2);
			//print_r($src);
			$x = $this->input->post('x');
			$y = $this->input->post('y');
			$width = $this->input->post('w');
			$height = $this->input->post('h');
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= '../'.$src;
			$config['width'] = $width;
			$config['height'] = $height;
			$config['create_thumb'] = FALSE;
                        $config['maintain_ratio'] = FALSE; 
		
			$config['x_axis'] = $x;
			$config['y_axis'] = $y;
			$config['new_image'] = $uploaddir.'/crop';
			//$config['new_image'] = '../'.$src.'-crop';
			$this->image_lib->initialize($config);
			
			if(!$this->image_lib->crop()){
    			echo $this->image_lib->display_errors();
			}
			
			
			/*
			$targ_w = $targ_h = 150;
			$jpeg_quality = 90;
			
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor($targ_w, $targ_h);
			
			imagecopyresampled($dst_r, $img_r, 0, 0, $x, $y, $targ_w, $targ_h, $width, $height);
			
			//header('Content-type: image/jpeg');
			//imagejpeg($dst_r, null, $jpeg_quality));*/
	}
        
        public function path( $id ){
            
            if($id > 0){
                $image = $this->Images_model->getImage( $id );
                $path = base_url() . substr( $image->path, 2 );
            }else{
                $path = "../path/to/default/image.jpg";
            }
            return $path;
            
        }
        
        public function pathByEntryAndDimension( $entry_id, $dimension = "large" ){
            $images = $this->Images_model->getImagesByEntry( $entry_id );
            $dimension = $this->Dimensions_model->getByName( $dimension );
            $path = "../path/to/default/image.jpg";
            //pre_dump($images);
            foreach ( $images as $image ){
                $tmp_image = $this->Images_model->getImageByDimesion( $image->image_id, $dimension->id );
                if( $tmp_image ){
                    $result_image = $tmp_image;
                }
            }
            //var_dump( $result_image );
            //TODO: Add frontend path in BE
            $path = base_url() . $result_image->path;
            //$path = $result_image->path;
            return $path;
        }
        
        public function getDimension( $name, $axis ){
            $dimension = $this->Dimensions_model->getByName( $name );
            return $dimension->$axis;
        }
        
        
	
}

/* End of file Images.php */
/* Location: ./system/application/controllers/Images.php */