<?php
class Paginator {
	var $items_per_page;
	var $items_total;
	var $current_page;
	var $num_pages;
	var $mid_range;
	var $low;
	var $high;
	var $limit;
	var $return;
	var $do;
	var $min;
	function __constructor($current_page = 1,$mid_range = 7 , $items_per_page = 20) {
		$this->current_page = $current_page;
		$this->mid_range = $mid_range;
		$this->items_per_page = $items_per_page;
	}

	function paginate() {
		if (!is_numeric($this->items_per_page) OR $this->items_per_page <= 0)
			$this->items_per_page = 20;
		$this->num_pages = ceil($this->items_total / $this->items_per_page);
		$this->current_page = (int)$_REQUEST['hpage'];
		if ($this->current_page < 1 Or !is_numeric($this->current_page))
			$this->current_page = 1;
		if ($this->current_page > $this->num_pages)
			$this->current_page = $this->num_pages;
		$prev_page = $this->current_page - 1;
		$next_page = $this->current_page + 1;
		$this->low = ($this->current_page - 1) * $this->items_per_page;
		$this->limit = ($_REQUEST['ipp'] == 'All') ? "" : " LIMIT $this->low,$this->items_per_page";
		$this->min = (intval($this->num_pages) > 0) ? 1 : 0;
		if ($this->low < 0)
			$this->low = -1;
	}

	function set_high() {
		global $wpdb;
		$this->high = ($_REQUEST['ipp'] == 'All') ? $this->items_total : $this->low + $wpdb->num_rows;
		if ($this->high < 0)
			$this->high = 0;
	}

	function show() {
		if ($this->high == 0 || $this->high == 1)
			echo "نمایش {$this->high} مورد";
		else {
			$low = $this->low + 1;
			echo "نمایش {$low} تا {$this->high} از {$this->items_total} مورد";
		}
	}

}
