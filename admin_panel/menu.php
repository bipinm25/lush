<?php include_once('header.php'); ?>
<section>
<section class="hbox stretch">
<aside class="bg-light lter b-r aside-md hidden-print" id="nav">          
          <section class="vbox">            
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
								<li <?=basename($_SERVER['PHP_SELF'])=="dashboard.php"?'class="active"':'' ?>  >
                      <a href="dashboard.php"  >
                        <i class="fa fa-dashboard icon">
											<b class="bg-success"></b>
                        </i>
                        <span>Dashboard</span>
                      </a>
                    </li>
								<li <?=in_array(basename($_SERVER['PHP_SELF']),['product_edit.php','product_list.php'])?'class="active"':'' ?> >
						<a href="product_list.php"  >
										<i class="fa fa-cogs icon">
								<b class="bg-success"></b>
							</i>
										<span>Products</span>
						</a>
					</li>
								<li <?=basename($_SERVER['PHP_SELF'])=="order_list.php"?'class="active"':'' ?> >
									<a href="order_list.php">
										<i class="fa fa-list-alt">
											<b class="bg-success"></b>
										</i>
										<span>Order List</span>
									</a>
								</li>
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-light">
              <div id="chat" class="dropup">
                <section class="dropdown-menu on aside-md m-l-n">
                  <section class="panel bg-white">
                    <header class="panel-heading b-b b-light">Active chats</header>
                    <div class="panel-body animated fadeInRight">
                      <p class="text-sm">No active chats.</p>
                      <p><a href="#" class="btn btn-sm btn-default">Start a chat</a></p>
                    </div>
                  </section>
                </section>
              </div>
              <div id="invite" class="dropup">                
                <section class="dropdown-menu on aside-md m-l-n">
                  <section class="panel bg-white">
                    <header class="panel-heading b-b b-light">
                      John <i class="fa fa-circle text-success"></i>
                    </header>
                    <div class="panel-body animated fadeInRight">
                      <p class="text-sm">No contacts in your lists.</p>
                      <p><a href="#" class="btn btn-sm btn-facebook"><i class="fa fa-fw fa-facebook"></i> Invite from Facebook</a></p>
                    </div>
                  </section>
                </section>
              </div>
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-default btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>              
            </footer>
          </section>
        </aside>
 <section id="content">
<section class="vbox">
<section class="scrollable padder">
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
	<li>
		<a href="dashboard.php">
			<i class="fa fa-home"></i> Home</a>
	</li>
	<?php
		if (isset($bread_cums) && !empty($bread_cums)){
			foreach ($bread_cums as $text=>$url) {
				echo '<li><a href="'.$url.'">'.$text.'</a></li>';
			}
		}
	?>

</ul>