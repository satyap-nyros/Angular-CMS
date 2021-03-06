<?php
class Aj_posts_model extends CI_Model 
{

	function insert_draft($data)
	{
		$this->db->insert('aj_posts',$data);
		return $this->db->insert_id();		
		
	}

	function insert_postmeta_last($l_id)
	{
		$data = array('post_id'=>$l_id,'meta_key'=>'_edit_last','meta_value'=>round(microtime(true) * 1000).':1');
		$this->db->insert('aj_postmeta',$data);
	}

	function insert_postmeta_lock($l_id)
	{	
		$data = array('post_id'=>$l_id,'meta_key'=>'_edit_lock','meta_value'=>1);
		$this->db->insert('aj_postmeta',$data);
	}

	function update_draft_guid($l_id)
	{
		$data = array('guid'=>'#page='.$l_id);
		$this->db->where('ID', $l_id);
		$this->db->update('aj_posts', $data);
		return $l_id;		
	}

	function update_org_row($data)
	{
		$this->db->where('ID', $data->ID);
		return $this->db->update('aj_posts', $data);	
	}

	function insert_metapost($meta_data)
	{
		return $this->db->insert('aj_postmeta',$meta_data);
	}
	
	
	function insert_page($data)
	{
		$query = "SELECT * FROM aj_posts WHERE post_title='".$data->post_title."'";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		else
		{
			$ins_query = $this->db->insert('aj_posts',$data);
			return 1;
		}
		
	}

	function update_page($data)
	{
		$this->db->where('ID' , $data->ID);
		return $this->db->update('aj_posts', $data);		
	}

	function updatepage_cmt($data)
	{
		$this->db->set('comment_count', 'comment_count+1',FALSE);
		$this->db->where('ID' , $data->ID);
		return $this->db->update('aj_posts');	
	}

	function fetch_sel_pages($data)
	{
		if($data->pages_cat == "all")
		{			
			$query = "SELECT * FROM aj_posts WHERE post_status IN('publish','draft')";
		}
		else
		{
			$query = "SELECT * FROM aj_posts WHERE post_status='".$data->pages_cat."'";
		}	
		
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->result_array();
		}
		return false;
	}
	
	function pages_count()
	{
		$query = "SELECT count('post_status'),post_status FROM aj_posts where post_status IN('publish','draft','trash') group by post_status order by post_status";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->result_array();
		}
		return false;
	}	
	
	function fetch_onepage($data)
	{
		$query = "SELECT * FROM aj_posts WHERE ID=".$data->ID." AND post_status='".$data->post_status."'";
		
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}

	function get_if_inherit($par_id)
	{
		$query = "SELECT * FROM aj_posts WHERE post_parent=".$par_id." AND post_status='inherit'";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}
	
	function update_draft($data)
	{
		$this->db->where('post_parent', $data->post_parent);
		$this->db->where('post_status', $data->post_status);
		return $this->db->update('aj_posts', $data);
	}

	/*function trash_page($pid)
	{
		//return $this->db->delete('aj_posts', array('ID' => $pid));
		
	}*/

	function get_auto_save($data)
	{
		$query = "SELECT * FROM aj_posts WHERE post_parent=".$data->post_parent." AND post_status='".$data->post_status."' AND post_name='".$data->post_name."'";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row();
		}
		return false;
		
	}
	function update_auto_save($data)
	{
		$this->db->where('post_parent', $data->post_parent);
		$this->db->where('post_status', $data->post_status);
		$this->db->where('post_name', $data->post_name);
		return $this->db->update('aj_posts', $data);		
	}

	function del_auto_save($data)
	{
		$this->db->where('post_parent', $data->ID);
		$this->db->where('post_status', 'inherit');
		$this->db->where('post_name', $data->ID.'-autosave-v1');
		return $this->db->delete('aj_posts');
	}

	function get_row_bsd_id($pid)
	{
		$query = "SELECT * FROM aj_posts WHERE ID=".$pid."";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			return $res_raw->row_array();
		}
		return false;
	}

	function delete_sel_page($data)
	{		
		$this->db->delete('aj_posts', array('ID' => $data->ID));
		$this->db->delete('aj_posts', array('post_parent' => $data->ID));
		return $this->db->delete('aj_postmeta', array('post_id' => $data->ID));	
	}

	function restore_sel_page($data)
	{
		$query = "SELECT * FROM aj_postmeta WHERE post_id=".$data->ID." && meta_key='_wp_trash_meta_status'";
		$res_raw = $this->db->query($query);
		if($res_raw->num_rows)
		{
			$result = $res_raw->row_array();
			$input = array('post_status'=>$result['meta_value']);
			$this->db->where('ID', $data->ID);
			return $this->db->update('aj_posts', $input);
			
		}
		return false;
		
	}
	
}
?>
