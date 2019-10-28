<?php

class pp_pagination {
	private $total = 0;
	private $per_page = 50;
	private $page = 0;

	public function __construct( $total, $per_page, $page ) {
		$this->total    = $total;
		$this->page     = $page;
		$this->per_page = $per_page;

		if($per_page == 0){
		    $this->per_page = 50;
        }

		if ( $page <= 0 ) {
			$this->page = 1;
		}
		if ( $page > ceil( $total / $per_page ) ) {
			$this->page = ceil( $total / $per_page );
		}
	}

	// determine what the current page is also, it returns the current page
	public function show() {
		$pageCount = ceil( $this->total / $this->per_page );
		$prev      = $this->page - 1;
		$next      = $this->page + 1;

		?>

        <div class="tablenav-pages">
            <span class="pagination-links">
               <a class="button prev-page" href="<?=$_SERVER['REQUEST_URI'] ?>&p=<?=$prev?>">
                   <span class="screen-reader-text">برگه قبل</span>
                   <span aria-hidden="true">‹</span>
               </a>

                <span id="table-paging" class="paging-input">
                    <span class="tablenav-paging-text"><?= $this->page ?> از <span
                                class="total-pages"><?= $pageCount ?></span></span>
                </span>
                <a class="button next-page" href="<?=$_SERVER['REQUEST_URI'] ?>&p=<?= $next ?>">
                        <span class="screen-reader-text">برگه بعد</span>
                        <span aria-hidden="true">›</span>
                </a>
            </span>
        </div>

		<?php
	}
}
