<?php 
date_default_timezone_set('Asia/Bangkok');
class Date{
	
	//output : d/m/y
	public function Now_BE(){
		$d = date("d");
		$m = date("m");
		$y = date("Y");
		$y = $y+543;
		return $d.'/'.$m.'/'.$y;
	}
	
	//output : d/m/y
	public function Now_BC(){
		$d = date("d");
		$m = date("m");
		$y = date("Y");
		return $d.'/'.$m.'/'.$y;
	}
	
	//BE to BC
	//input : d/m/y (BE)
	//output : y-m-d
	public function converseBEToBC($date){
		$dt = explode("/",$date);
		$d = $dt[0];
		$m = $dt[1];
		$y = $dt[2]-543;
		return $y.'-'.$m.'-'.$d;
	}
	
	//BE to BC
	//input : y-m-d (BE)
	//output : d/m/y
	public function converseBEToBC2($date){
		$dt = explode("-",$date);
		$d = $dt[2];
		$m = $dt[1];
		$y = $dt[0]-543;
		return $d.'/'.$m.'/'.$y;
	}
	
	//BC to BE
	//input : d/m/y (BC)
	//output : y-m-d
	public function converseBCToBE($date){
		$dt = explode("/",$date);
		$d = $dt[0];
		$m = $dt[1];
		$y = $dt[2]+543;
		return $y.'-'.$m.'-'.$d;
	}
	
	//BC to BE
	//input : y-m-d (BC)
	//output : d/m/y
	public function converseBCToBE2($date){
		$dt = explode("-",$date);
		$d = $dt[2];
		$m = $dt[1];
		$y = $dt[0]+543;
		return $d.'/'.$m.'/'.$y;
	}
	
}

?>