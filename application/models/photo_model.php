<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Photo_model extends CI_Model {

        public function __construct()
        {
			parent::__construct();
			$this->photo_table = 'Photos';
        }

		public function addPhoto($data)
		{
			return $this->db->insert($this->photo_table, $data);
		}

        public function getAll()
        {
            $this->db->from($this->photo_table);
			$this->db->select('Created, Filename_Large, Filename_Thumbnail, Title');
			$this->db->order_by('Created, Filename');

			$query = $this->db->get();
	
			$photos = array();

			foreach ($query->result_array() as $row)
			{
				$b = array();
				foreach($row as $key => $value)
				{
					$b[$key] = $value;
				}
				$photos[] = $b;
				unset($b);
			}

			return $photos;
        }
        
        public function getFilenames()
        {
            $this->db->from($this->photo_table);
			$this->db->select('Filename');
			$this->db->order_by('Created, Filename');

			$query = $this->db->get();
	
			$files = array();

			foreach ($query->result() as $row)
			{
				$files[] = $row->Filename;
			}

			return $files;
        }

		public function getInfo($src)
		{
			$this->db->from($this->photo_table);
			$this->db->select('Title, Description, FileDateTime');
			$this->db->where('Filename_Large', $src);

			$query = $this->db->get();

			return $query->num_rows() > 0 ? $query->row() : false;
		}

        public function getLatest()
        {
			$sql = "SELECT Created, Filename, Title, MAX(Created) AS Created_Max FROM ".$this->photo_table." HAVING MAX(Created) ORDER BY Filename ";
			//$this->db->select('Created, Filename, Title');
			//$this->db->select_max('Created', 'Created_Max');
			//$this->db->Having('Created', 'MAX(Created)');
			//$this->db->order_by('Filename');

			$query = $this->db->query($sql);
	
			$photos = array();

			foreach ($query->result_array() as $row)
			{
				$b = array();
				foreach($row as $key => $value)
				{
					$b[$key] = $value;
				}
				$photos[] = $b;
				unset($b);
			}

			return $photos;
        }

    }

?>