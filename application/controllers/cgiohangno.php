<?php 
class Cgiohangno extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array("url","form"));
		$this->load->library(array("form_validation","my_layout","session","my_auth","email","cart","MY_Cart"));
		$this->load->model("Mcart");
		$this->my_layout->setLayout("vtrangchu");
		$this->load->model("Mtrangchu");
		$this->load->model("muser");
		
		//$this->load->model("mhome");
	}
	public function index(){
		
		
		
	$userid = $this->my_auth->idkhach;
            $data['info'] = $this->muser->getInfokhach($userid);
			$data['danhmuccha'] = $this->muser->showdanhmuccha();
		$data['title'] ="Đặt hàng"; 
		$data['info2'] = $this->cart->contents();
		$data['tinhthanh'] = $this->muser->laytinhthanh();
		
		
		if(isset($_POST['chapnhan'])){
            $diachi=$_POST['sonha']."|".$_POST['duong']."|".$_POST['phuongxa']."|".$_POST['quanhuyen']."|".$_POST['tinhthanh'];
			$thongtin=array(
				"hoten" => $_POST['hoten'],
				"diachi" => $diachi,
				"phone" => $_POST['dienthoai'],
				
			);
			
			$this->muser->updateUser($thongtin,$userid);
			//$this->cart->destroy();
			redirect(base_url().'cgiohang#p1');
            
        }
		
		
		if(isset($_POST['ok'])){
			
			function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobile()){
    $ngaythang= date('d/m/Y - H:i').' - (Mobile)';
}else{
	$ngaythang= date('d/m/Y - H:i').' - (PC)';
}
			
            $a=$this->cart->contents();
			
			
			$thongtindiachi = $this->muser->thongtindiachi($_POST['phuongxa']);
			echo $_POST['phuongxa'];
			print_r($thongtindiachi);
			if($_POST['sonha']=="")
			{
				$sonha="Số nhà Không có";
			}
			else
			{
				$sonha=$_POST['sonha'];
			}
			if($_POST['duong']=="")
			{
				$duong="Đường Không có";
			}
			else
			{
				$duong="Đường ".$_POST['duong'];
			}
			$diachi=$sonha."|".$duong."|".$thongtindiachi['wardtype']." ".$thongtindiachi['wardname']."|".$thongtindiachi['districttype']." ".$thongtindiachi['districtname']."|".$thongtindiachi['provincetype']." ".$thongtindiachi['provincename'];
			
			/*foreach($a as $item)
			{
				$stt=$item['id'];
				$dongia=$item['price'];
				$soluong=$item['qty'];
			}*/
			$cart_data = array();
            $i = 0;
			//$tongtien=($soluong*$dongia)+$vanchuyen;
			$ghichu=$_POST['ghichu'];
			//$noigiao=$data['info']['diachi'];
			$sosanpham=count($this->cart->contents());
            $inserthoadon =array(
				"tenkhach" => $_POST['hoten'],
				"phone" => $_POST['dienthoai'],
				"ngaydat" => $ngaythang,
				"tongtien" => $this->cart->total(),
				"ghichu" => $ghichu,
				"noigiao" => $diachi,
			);
			$idvuainsert = $this->Mcart->dathanghoadon($inserthoadon);
			
            foreach($this->cart->contents() as $item){
                $cart_data[$i]['idhoadon'] = $idvuainsert;
                $cart_data[$i]['stt'] = $item['id'];
				//$cart_data[$i]['idkhach'] = 1;
				//$cart_data[$i]['tenkhach'] = $_POST['hoten'];
				$cart_data[$i]['tensp'] = $item['name'];
				//$cart_data[$i]['ngaydat'] = $ngaythang;
                $cart_data[$i]['soluong'] = $item['qty'];
                $cart_data[$i]['dongia'] = $item['price'];
				
                $cart_data[$i]['tongcong'] = $item['subtotal'];
				//$cart_data[$i]['mauchon'] = $item['options']['mauchon'];
				$cart_data[$i]['sizechon'] = $item['options']['sizechon'];
				//$cart_data[$i]['ghichu'] = $ghichu;
				//$cart_data[$i]['noigiao'] = $diachi;
				//$cart_data[$i]['chieucao'] = $_POST['chieucao'];
				//$cart_data[$i]['cannang'] = $_POST['cannang'];
                $i++;
            }
			
			
			
			
			
			$this->Mcart->dathang($cart_data);
			$this->cart->destroy();
			
			
			
			redirect(base_url().'ctrangchu/thanhcong');
            
        }
		
		
		if(count($data['info2'])!=0)
		{
		
		
		$data['sanpham']=$this->Mtrangchu->listall();
	$data['danhmuccha'] = $this->muser->showdanhmuccha();
		$data['hienthi']=3;
        //$data['loaisp']=$this->mhome->get_theloai();
		
		//$data['sanpham']=$this->Mtrangchu->listall();
        //$data['loaisp']=$this->mhome->get_theloai();
		
        
		
		$a=$this->cart->contents();
		$dem=0;
		$data['gram']=0;
		$data['tienship']=0;
			foreach($a as $item)
			{
				$stt=$item['id'];
				$data['info1'] = $this->Mcart->getProductById($stt);
				
			}
		
		$this->my_layout->view("view_cart1",$data);
		}
		else
		{
			redirect(base_url().'ctrangchu');
		}
		
	}
	public function add(){
		
		
		
		//$this->cart->destroy();
		$id = $this->uri->segment(2);
		$data= $this->Mcart->getProductById($id);
		
		//$now = getdate();
		//$ngayketthuc=substr($data['ngayketthuc'],6,4)."/".substr($data['ngayketthuc'],3,2)."/".substr($data['ngayketthuc'],0,2);
		
		//$time=mktime($now["hours"],$now["minutes"],$now["seconds"],$now["mon"],$now["mday"],$now["year"]);
		
		//$time1=mktime($ngayketthuc["hours"],$ngayketthuc["minutes"],$ngayketthuc["seconds"],$ngayketthuc["mon"],$ngayketthuc["mday"],$ngayketthuc["year"]);
		
		
		
		$getshop=$this->cart->contents();
		$data['qty']=1;
		
		$shop=array(
				'id'=>$data['stt'],
				'masp'=>$data['idsp'],
				'name'=>$data['tensp'],
				'price'=>$data['giagiam'],
				'hinhanh'=>$data['hinhanhchinh'],
				'mau'=>$data['mau'],
				'size'=>$data['size'],
				'options' => array('mauchon'=>$_POST['mauchon'], 'sizechon'=>$_POST['sizechon'], 'wei'=>$data['trongluong']),
				'trongluong'=>$data['trongluong'],
				
				
				//'vanchuyen'=>$data['vanchuyen'],
				'qty'=>$data['qty'],
				'subtong'=>$data['giagiam']*$data['qty'],
		);
		
		$this->cart->insert($shop);
		redirect(base_url().'cgiohangno','refresh');
		
	}
	
	public function addnew(){
		
		
		
		//$this->cart->destroy();
		$id = $this->uri->segment(2);
		$data= $this->Mcart->getProductById($id);
		$somau=count(explode("|", $data['size'])); 
		
		if($_POST['soluong']>0)
			{
				$shop=array(
					'id'=>$data['stt'],
					'masp'=>$data['idsp'],
					'name'=>$data['tensp'],
					'slug'=>$data['slug'],
					'price'=>$data['giagiam'],
					'hinhanh'=>$data['hinhanhchinh'],
					'mau'=>$data['mau'],
					'size'=>$data['size'],
					'options' => array('mauchon'=>$_POST['mauchon'], 'sizechon'=>$_POST['sizechon']),
					
					
					//'vanchuyen'=>$data['vanchuyen'],
					'qty'=>$_POST['soluong'],
					'subtong'=>$data['giagiam']*$_POST['soluong'],
		);
		
		$this->cart->insert($shop);
			}
		//$now = getdate();
		//$ngayketthuc=substr($data['ngayketthuc'],6,4)."/".substr($data['ngayketthuc'],3,2)."/".substr($data['ngayketthuc'],0,2);
		
		//$time=mktime($now["hours"],$now["minutes"],$now["seconds"],$now["mon"],$now["mday"],$now["year"]);
		
		//$time1=mktime($ngayketthuc["hours"],$ngayketthuc["minutes"],$ngayketthuc["seconds"],$ngayketthuc["mon"],$ngayketthuc["mday"],$ngayketthuc["year"]);
		
		
		
		
		
		
		
		redirect(base_url().'cgiohangno','refresh');
		
	}
	
	public function add1(){
		
		
		
		//$this->cart->destroy();
		$id = $this->uri->segment(2);
		$data= $this->Mcart->getProductById($id);
		
		//$now = getdate();
		$ngayketthuc=substr($data['ngayketthuc'],6,4)."/".substr($data['ngayketthuc'],3,2)."/".substr($data['ngayketthuc'],0,2);
		
		//$time=mktime($now["hours"],$now["minutes"],$now["seconds"],$now["mon"],$now["mday"],$now["year"]);
		
		//$time1=mktime($ngayketthuc["hours"],$ngayketthuc["minutes"],$ngayketthuc["seconds"],$ngayketthuc["mon"],$ngayketthuc["mday"],$ngayketthuc["year"]);
		
		if(strtotime($ngayketthuc)>strtotime(date('Y/m/d')))
		{
		
		$getshop=$this->cart->contents();
		$data['qty']=1;
		
		$shop=array(
				'id'=>$data['stt'],
				'masp'=>$data['idsp'],
				'name'=>$data['tensp'],
				'price'=>$data['giagiam'],
				'hinhanh'=>$data['hinhanhchinh'],
				'mau'=>$data['mau'],
				'size'=>$data['size'],
				'sizechon'=>$_POST['sizechon'],
				'options' => array( 'sizechon'=>$_POST['sizechon']),
				
				//'vanchuyen'=>$data['vanchuyen'],
				'qty'=>$data['qty'],
				'subtong'=>$data['giagiam']*$data['qty'],
		);
		
		$this->cart->insert($shop);
		redirect(base_url().'cgiohangno','refresh');
		}
		else
		{
			$this->load->view("vloi9999");
		}
	}
	
	public function thanhtoan(){
        
		if($this->input->post()){
            $post_data = $this->input->post('data');
            
            
            
            
            // Lưu đơn hàng
            $cart_data = array();
            $i = 0;
            
            foreach($this->cart->contents() as $item){
                
                $cart_data[$i]['stt'] = $item['id'];
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
	
	public function update(){
	//print_r($this->input->post());
		for ($i = 0; $i <= $this->cart->total_items(); $i++){
            $item = $this->input->post($i);
			
            $data = array(
                    'rowid'    => $item['rowid'],
                    'qty'    => $item['qty'],
					'options' => array('mauchon'=>$item['options']['mauchon'], 'sizechon'=>$item['options']['sizechon']),
				
					
                        );
            $this->cart->update_options($data);
            } 
		$data['info2'] = $this->cart->contents();
		
		//print_r($data['info2']);
		
		redirect(base_url().'cgiohangno#p1','refresh');
	}
	public function del(){
		$id = $this->uri->segment(3);
		$data = $this->cart->contents();
		foreach ($data as $val) {
			if ($val['rowid'] == $id) {
				$data_remove = array(
					"rowid" =>$val['rowid'],
					"qty"=>0
				);
				$this->cart->update($data_remove);
			}
		}
		redirect(base_url().'cgiohangno#p1','refresh');
	}
	
	public function xoasach(){
		$this->cart->destroy();
		redirect(base_url().'cgiohangno#p1','refresh');
	}
	
	
	function show() {
		
		$cart = $this->cart->contents();
		
		echo "<pre>";
		print_r($cart);
	}

}
?>