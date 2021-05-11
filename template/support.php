<?php

/* 
* Template name: Support Page
* Version: 1.0
*/

get_header();

ces_page_header(get_the_title(), 'Dashboard', site_url());

?>

<section class="content">
    <div class="container-fluid pb-3">
        <div class="d-flex justify-content-center row">
            <div class="col-md-6 support-container" id="dbgDataTable">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Support Center</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?= gravity_form('1',  false, false,  false,  null,  true,  1,  true);  ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php

get_footer();
