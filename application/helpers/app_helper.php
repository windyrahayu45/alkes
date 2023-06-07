<?php

function isLogin() {

	//meamnggil variable ci agar bisa menggunakan library ci
	$ci = get_instance(); 
	if(!$ci->session->userdata('level')) {
		redirect('');die;
	}

}

?>