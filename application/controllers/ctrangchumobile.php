﻿<?php
class Ctrangchumobile extends CI_Controller{

	var $_register = "register"; // ten cua session register khi dang ki thanh vien
    var $_fgpassword = "fgpassword";
    public function __construct(){
        parent::__construct();
		$this->load->helper(array("url","date","my_data"));
        $this->load->library(array("form_validation","my_layout","session","email","my_auth","cart"));
        $this->my_layout->setLayout("vtrangchumobile");
     
        $this->load->database();
        $this->load->model("Mtrangchu");
		$this->load->model("muser");
		//$this->load->model("mhome");
		
    }
    public function index(){
        
		
        $userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
		$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=1;
		
		$data['title']="Deal Hàng Việt - dealhangviet.vn";
		$data['des']="Deal Hàng Việt - Sản phẩm khuyến mãi giá rẻ chỉ có tại dealhangviet.vn";
		
		$min = 9;
		$max = $this->muser->getsanphamnumrows();
		$data['num_rows'] = $max;
		if($max!=0){
            
            $this->load->library('pagination');
            $config['base_url'] = base_url()."trang-chu-mobile.html/";
            $config['total_rows'] = $max;
            $config['per_page'] = $min;
            $config['num_link'] = 1; 
            $config['uri_segment'] = 2;
			$config['cur_tag_open'] = '<strong style="margin-left:4px;" class="pagination-selected-page">';
			$config['cur_tag_close'] = '</strong>';
            $this->pagination->initialize($config);
            
            $data['link'] = $this->pagination->create_links();
            $data['sanpham'] = $this->Mtrangchu->listall($min,$this->uri->segment($config['uri_segment']));
            
            $this->my_layout->view("vspmobile",$data);
        
        }else{
			
            $data['report'] = "Khong co du lieu de hien thi";
            $this->my_layout->view("backend/report",$data);
        }
        
			

    }
	
	public function loaisptheochamobile($a=""){
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        
		//$iddm1=explode("-",$this->uri->segment(2));
		$iddm=$a;
        $this->Mtrangchu->listsptheocha($a);
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=3;
		$data['tendanhmuc']=$this->Mtrangchu->layiddmcha($iddm);
		$data['title']=$data['tendanhmuc']['tendmcha'];
		$data['des']="Deal Hàng Việt - ".$data['title']." khuyến mãi giá rẻ chỉ có tại dealhangviet.vn";
        $min = 9;
		$max = $this->muser->getsanphamtheochanumrows($iddm);
		$data['num_rows'] = $max;
		if($max!=0){
            
            $this->load->library('pagination');
            $config['base_url'] = base_url()."ctrangchumobile/loaisptheochamobile/".$iddm."/index";
            $config['total_rows'] = $max;
            $config['per_page'] = $min;
            $config['num_link'] = 1; 
            $config['uri_segment'] = 5;
			$config['cur_tag_open'] = '<strong style="margin-left:4px;" class="pagination-selected-page">';
			$config['cur_tag_close'] = '</strong>';
            $this->pagination->initialize($config);
            
            $data['link'] = $this->pagination->create_links();
			$data['sanpham']=$this->Mtrangchu->listsptheocha($iddm,$min,$this->uri->segment($config['uri_segment']));
            
            
            $this->my_layout->view("vloaispmobile",$data);
        
        }else{
			$data['tendanhmuc']=$this->Mtrangchu->layiddmcha($iddm);
            $data['report'] = '<div style="margin-left:30px;font-size:30px">Chưa có sản phẩm nào</div>';
            $this->my_layout->view("report",$data);
        }
			

    }
	
	public function loaisptheoconmobile($b=""){
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        
		//$iddm1=explode("-",$this->uri->segment(2));
		$iddm=$b;
        
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['hienthi']=3;
		$data['tendanhmuc']=$this->Mtrangchu->layiddmcon($iddm);
		$data['title']=$data['tendanhmuc']['tendmcon'];
		$data['des']="Deal Hàng Việt - ".$data['title']." khuyến mãi giá rẻ chỉ có tại dealhangviet.vn";
		$min = 9;
		$max = $this->muser->getsanphamtheoconnumrows($iddm);
		$data['num_rows'] = $max;
		if($max!=0){
            
            $this->load->library('pagination');
            $config['base_url'] = base_url()."ctrangchumobile/loaisptheoconmobile/".$iddm."/index";
            $config['total_rows'] = $max;
            $config['per_page'] = $min;
            $config['num_link'] = 1; 
            $config['uri_segment'] = 5;
			$config['cur_tag_open'] = '<strong style="margin-left:4px;" class="pagination-selected-page">';
			$config['cur_tag_close'] = '</strong>';
            $this->pagination->initialize($config);
            
            $data['link'] = $this->pagination->create_links();
			$data['sanpham']=$this->Mtrangchu->listsptheocon($iddm,$min,$this->uri->segment($config['uri_segment']));
			
            
            
            $this->my_layout->view("vloaispconmobile",$data);
        
        }else{
			$data['tendanhmuc']=$this->Mtrangchu->layiddmcon($iddm);
            $data['report'] = '<div style="margin-left:30px;font-size:30px">Chưa có sản phẩm nào</div>';
            $this->my_layout->view("report1",$data);
        }
			

    }
	
	public function loaisptheosubconmobile($b=""){
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        
		//$iddm1=explode("-",$this->uri->segment(2));
		$iddm=$b;
        
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['hienthi']=3;
		$data['tendanhmuc']=$this->Mtrangchu->layiddmsubcon($iddm);
		$data['title']=$data['tendanhmuc']['tendmsubcon'];
		$data['des']="Deal Hàng Việt - ".$data['title']." khuyến mãi giá rẻ chỉ có tại dealhangviet.vn";
		$min = 9;
		$max = $this->muser->getsanphamtheosubconnumrows($iddm);
		$data['num_rows'] = $max;
		if($max!=0){
            
            $this->load->library('pagination');
            $config['base_url'] = base_url()."ctrangchumobile/loaisptheosubconmobile/".$iddm."/index";
            $config['total_rows'] = $max;
            $config['per_page'] = $min;
            $config['num_link'] = 1; 
            $config['uri_segment'] = 5;
			$config['cur_tag_open'] = '<strong style="margin-left:4px;" class="pagination-selected-page">';
			$config['cur_tag_close'] = '</strong>';
            $this->pagination->initialize($config);
            
            $data['link'] = $this->pagination->create_links();
			$data['sanpham']=$this->Mtrangchu->listsptheosubcon($iddm,$min,$this->uri->segment($config['uri_segment']));
			
            
            
            $this->my_layout->view("vloaispsubconmobile",$data);
        
        }else{
			$data['tendanhmuc']=$this->Mtrangchu->layiddmsubcon($iddm);
            $data['report'] = '<div style="margin-left:30px;font-size:30px">Chưa có sản phẩm nào</div>';
            $this->my_layout->view("report2",$data);
        }
			

    }
	
	
	public function chitiet($c=""){
        
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        $sp=$c;
        $data['sanpham']=$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['chitietsp']=$this->Mtrangchu->getInfochitietsp($sp);
		$data['splienquan']=$this->Mtrangchu->getInfosplienquan($data['chitietsp']['iddmcon'],$data['chitietsp']['stt']);
		$data['title']=$data['chitietsp']['tensp'];
		$data['des']=$data['chitietsp']['des'];
		$data['key']=$data['chitietsp']['tukhoa'];
		$data['hienthi']=2;
		
		
        
            //$userid = $this->my_auth->userid;
            //$data['info'] = $this->muser->getInfo($userid);
            //$data['about']=$this->mhome->get_about();
            //$this->load->view("frontend/user/home_view",$data);
			//print_r($data['chitietsp']);
			$this->my_layout->view("vchitiet",$data);
			
    }
	
	public function chitietmobile($c=""){
        
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        $sp=$c;
        $data['sanpham']=$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['chitietsp']=$this->Mtrangchu->getInfochitietsp($sp);
		$data['splienquan']=$this->Mtrangchu->getInfosplienquan($data['chitietsp']['iddmcon'],$data['chitietsp']['stt']);
		$data['title']=$data['chitietsp']['tensp'];
		$data['des']=$data['chitietsp']['des'];
		$data['key']=$data['chitietsp']['tukhoa'];
		$data['hienthi']=2;
		
		
        
            //$userid = $this->my_auth->userid;
            //$data['info'] = $this->muser->getInfo($userid);
            //$data['about']=$this->mhome->get_about();
            //$this->load->view("frontend/user/home_view",$data);
			//print_r($data['chitietsp']);
			$this->my_layout->view("vchitietmobile",$data);
			
    }
	
	public function chitietmobileselect($c=""){
        
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        $sp=$c;
        $data['sanpham']=$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['chitietsp']=$this->Mtrangchu->getInfochitietsp($sp);
		$data['splienquan']=$this->Mtrangchu->getInfosplienquan($data['chitietsp']['iddmcon'],$data['chitietsp']['stt']);
		$data['title']=$data['chitietsp']['tensp'];
		$data['des']=$data['chitietsp']['des'];
		$data['key']=$data['chitietsp']['tukhoa'];
		$data['hienthi']=2;
		
		
        
            //$userid = $this->my_auth->userid;
            //$data['info'] = $this->muser->getInfo($userid);
            //$data['about']=$this->mhome->get_about();
            //$this->load->view("frontend/user/home_view",$data);
			//print_r($data['chitietsp']);
			$this->my_layout->view("vchitietmobileselect",$data);
			
    }
	
	public function danhmuccha(){
        
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
        $sp=$this->uri->segment(3);
        $data['sanpham']=$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		$data['chitietsp']=$this->Mtrangchu->getInfochitietsp($sp);
		$data['danhmuccha']=$this->Mtrangchu->getInfochitietsp($sp);
		
		
		
        
            //$userid = $this->my_auth->userid;
            //$data['info'] = $this->muser->getInfo($userid);
            //$data['about']=$this->mhome->get_about();
            //$this->load->view("frontend/user/home_view",$data);
			//print_r($data['chitietsp']);
			$this->my_layout->view("vchitiet",$data);
			
    }
	
	public function tintuc(){
        
		
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		
		$param              = $this->uri->segment(3);   
        
            $userid = $this->my_auth->userid;
            $data['info'] = $this->muser->getInfo($userid);
            
			$this->load->library('pagination');
                         $config['base_url']         = base_url().'ctrangchu/tintuc';            
                         $config['total_rows']       = $this->mhome->get_total_rows_tintuc();
                         //$config['use_page_numbers'] = TRUE;//hiển thị số trang đúng
                         $config['per_page']         = 3;  
                         $config['uri_segment']      = 3;                              
                         $this->pagination->initialize($config);                         
                         $data['tintuc']          = $this->mhome->get_tintuc($config['per_page'],$param); 
			
			$this->my_layout->view("news",$data);
			
    }

	
	public function new_detail(){
        
		
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		
		$param              = $this->uri->segment(3);   
        
            $userid = $this->my_auth->userid;
            $data['info'] = $this->muser->getInfo($userid);
            
			$this->load->library('pagination');
                         $config['base_url']         = base_url().'ctrangchu/tintuc';            
                         $config['total_rows']       = $this->mhome->get_total_rows_tintuc();
                         //$config['use_page_numbers'] = TRUE;//hiển thị số trang đúng
                         $config['per_page']         = 3;  
                         $config['uri_segment']      = 3;                              
                         $this->pagination->initialize($config);                         
                         $data['tintuc']          = $this->mhome->get_newdetail($param); 
			
			$this->my_layout->view("new_detail",$data);
			
    }
	
	public function dichvu(){
        
		
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		
		
			
			$this->my_layout->view("services",$data);
			
    }
	
	public function duandalam(){
        
		
        
$data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		
		
			
			$this->my_layout->view("duan",$data);
			
    }
	
	public function lienhe(){
        
		
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		
		
			
			$this->my_layout->view("contact",$data);
			
    }
	
	public function loaisanpham(){
        
		$param              = $this->uri->segment(3);   
        
        $data['loaisp']=$this->mhome->get_theloai();
		
		$data['content_cat']   = $this->mhome->content_theloai($param);
		
			
			$this->my_layout->view("categories",$data);
			
    }
	
	public function dkthanhcong(){
        
		
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		$data['title']="Đăng ký thành viên thành công";
		

		
		
			
			$this->my_layout->view("dkthanhcong",$data);
			
    }
	
	public function thanhtoan(){
        
		if($this->input->post()){
            $post_data = $this->input->post('data');
            $this->load->model('mcustomer');
            $insert_id = $this->mcustomer->add_customer($post_data);
            
            $tong_tien = 0;
            foreach($this->cart->contents() as $item){
                $tong_tien += $item['subtotal'];
            }
            
            $this->load->model('mcart');
            $cart_data = array(
                'id_khach_hang' => $insert_id,
                'tong_tien' => $tong_tien
            );
            
            $insert_id = $this->mcart->add_cart($cart_data);
            echo $insert_id;
            
            
            // Lưu đơn hàng
            $cart_data = array();
            $i = 0;
            
            foreach($this->cart->contents() as $item){
                $cart_data[$i]['id_cart'] = $insert_id;
                $cart_data[$i]['id_hang'] = $item['id'];
                $cart_data[$i]['so_luong'] = $item['qty'];
                $cart_data[$i]['don_gia'] = $item['price'];
                $cart_data[$i]['thanh_tien'] = $item['subtotal'];
                $i++;
            }
            
            if($this->mcart->add_cart_detail($cart_data))
                $data['message'] = 'Thanh toán thành công';
            
        }
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();

		$this->my_layout->view("thanhtoan",$data);
    }
	
	public function chitietsp(){
        
		$param              = $this->uri->segment(3);  
        
        $data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
		
		$data['chitietsp']=$this->mhome->getchitietsp($param);
		
		
			
			$this->my_layout->view("single_product",$data);
			
    }
	
	function register()
    {
	$data['sanpham']=$this->Mtrangchu->listall();
        $data['loaisp']=$this->mhome->get_theloai();
	
        //--- Neu Login thi khong duoc dang ki
        if($this->my_auth->is_Login()){
            redirect(base_url()."ctrangchu");
            exit();
        }
        
        $this->form_validation->set_rules("full_name","Full name","required|min_length[6]");
        $this->form_validation->set_rules("username","Username","required|max_length[25]|callback_checkUser");
        $this->form_validation->set_rules("password","Password","required|matches[repassword]");
        $this->form_validation->set_rules("email","Email","required|valid_email|callback_checkEmail");
        $this->form_validation->set_rules("address","Address","required");
        $this->form_validation->set_rules("phone","Phone number","required|callback_validPhone");
        $this->form_validation->set_rules("gender","Gender","required");
        
        if($this->form_validation->run()==FALSE){
            $data['error']="";
            $this->my_layout->view("frontend/user/register",$data);
			
        }
        else
        {
                $salt = create_random_string(5);
                $add = array(
                        "full_name" => $this->input->post("full_name"),
                        "username"  => $this->input->post("username"),
                        "salt"      => $salt,
                        "password"  => md5($this->input->post("password")),
                        "email"     => $this->input->post("email"),
                        "address"   => $this->input->post("address"),
                        "phone"     => $this->input->post("phone"),
                        "level"     => 2, // mac dinh la memmber khi dang ki thanh vien
                        "gender"    => $_POST['gender'],
                        "add_date"  => date("Y-m-d H:i:s"),
                        "active"    => 0, // chua kich hoat
                );

                //--- Xử lý ảnh : phần này không bắt buộc
                $img = "";
                $flag = TRUE;
                if($_FILES['image']['name'] != NULL){
                    $config['upload_path']   = 'public/images/avata/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']      = '5000';
                    $config['max_width']     = '2000';
                    $config['max_height']    = '2000';
                    $config['encrypt_name']  = true; // ma hoa ten file
                    $config['remove_spaces'] = true; // xoa khoang trang
                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload("image"))
                    {
                        $data['error'] = $this->upload->display_errors();
                        $this->my_layout->view("frontend/user/register",$data);
                        $flag = FALSE;
                    }
                    else
                    {
                        $img = $this->upload->data();
                        $add['image'] = $img['file_name'];
                    }
                }

                if($flag==TRUE){
                    //--- Gui mail kich hoat neu add thanh cong
                    $message = "";
                    if($this->muser->addUser($add)){

                        $userid = mysql_insert_id();
                        $link_active = base_url()."home/user/active/?userid=".$userid."&key=".md5($salt);
                        $message  = "Please follow this link to active your acount <br/>".
                        $message .= "Link : <a href=".$link_active.">".$link_active."</a><br/>";
                        $message .= "username : ".$add['username']."<br/>";
                        $message .= "password : ".$this->input->post("password");

                        $mail = array(
                                "to_receiver"   => $add['email'],
                                "message"       => $message,
                            );

                        $this->load->library("my_email");
                        $this->my_email->config($mail);
                        $this->my_email->sendmail();

                        $this->session->set_userdata(array($this->_register => TRUE));
                        redirect(base_url()."ctrangchu/dkthanhcong");
                    }
                }
        }
        
    }
	
	public function thanhcong()
	{
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			$data['title']="Đặt hàng thành công";
		$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=2;
		
            $this->my_layout->view("vthankyou",$data);
        
	}
	
	public function thanhcongmobile()
	{
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			$data['title']="Đặt hàng thành công";
		$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=2;
		
            $this->my_layout->view("vthankyoumobile",$data);
        
	}
	
	public function thongtinkhachhang()
	{
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			$data['title']="Thông tin khách hàng";
			if(count($data['info'])!=0)
			{
			
			
		$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		$data['menusubcon']=$this->Mtrangchu->menusubcon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=2;
		
            $this->my_layout->view("vthongtinkhachhang",$data);
			}
			else
			{
				redirect(base_url()."ctrangchu");
			}
        
	}
	
	public function xlthongtinkhachhang()
	{
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			if(isset($_POST['luu']))
			{
				if($_POST['password']!="")
				{
				//$username = $_POST['tendangnhap'],
				$diachi=$_POST['diachi0']."|".$_POST['diachi1']."|".$_POST['diachi2']."|".$_POST['diachi3']."|".$_POST['diachi4'];
			$thongtin=array(
				"hoten" => $_POST['hoten'],
				
				"password" => md5($_POST['password']),
				"email" => $_POST['email'],
				"gioitinh" => $_POST['gioitinh'],
				"diachi" => $diachi,
				"phone" => $_POST['dienthoai'],
				"ngaysinh" => $_POST['ngaysinh'],
			);
			}
			else 
			{
				//$username = $_POST['tendangnhap'],
				$diachi=$_POST['diachi0']."|".$_POST['diachi1']."|".$_POST['diachi2']."|".$_POST['diachi3']."|".$_POST['diachi4'];
			$thongtin=array(
				"hoten" => $_POST['hoten'],
				
				//"password" => md5($_POST['password']),
				"email" => $_POST['email'],
				"gioitinh" => $_POST['gioitinh'],
				"diachi" => $diachi,
				"phone" => $_POST['dienthoai'],
				"ngaysinh" => $_POST['ngaysinh'],
				);
			}
			
			$this->muser->updateUser1($thongtin,$userid);
			redirect(base_url()."ctrangchu/thongtinkhachhang");
			}
			redirect(base_url()."ctrangchu/thongtinkhachhang");
        
	}
	
	public function dangky()
	{
		
		$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			
			$data['title'] = "Đăng ký thành viên";
			
			if(count($data['info'])==0)
			{
		$this->Mtrangchu->listall();
		$data['menucha']=$this->Mtrangchu->menucha();
		$data['menucon']=$this->Mtrangchu->menucon();
		//$param              = $this->uri->segment(3);  
        $data['hienthi']=2;
		
            $this->my_layout->view("vdangky",$data);
			}
			else
			{
				redirect(base_url()."ctrangchu");
			}
        
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url()."ctrangchu");
	}
	
	
	
	
	
	
	
	
	
}