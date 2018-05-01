<nav id="site-navigation" class="main-navigation" aria-labelledby="site-navigation-label"
     itemscope="" itemtype="https://schema.org/SiteNavigationElement">
  
  <h2 class="screen-reader-text" id="site-navigation-label">Primary Menu</h2>
  
  
  <div id="main-navigation-inner" class="main-navigation-inner">
    
    <div class="menu">
      <ul role=menu>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Fine Tea, Coffee, Food, and Sodas' ) {echo 'class="active"';} ?> href="/index.php">Home</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Restaurants' ) {echo 'class="active"';} ?> href="/restaurants.php">Restaurants</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Products' ) {echo 'class="active"';} ?> href="/products.php">Products</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Blog' ) {echo 'class="active"';} ?> href="/blog.php">Blog</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Articles' ) {echo 'class="active"';} ?> href="/article.php">Articles</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Calendar' ) {echo 'class="active"';} ?> href="/calendar.php">Calendar</a>
        </li>
        <li class="menu-item" role="menuitem">
          <a <?php if ( $page == 'Contact Us' ) {echo 'class="active"';} ?> href="/contactus.php">Contact Us</a>
        </li>
        
        <?php if ( $_SESSION['email'] ) : ?>
          <li class="menu-item menu-item-has-children" role="menuitem">
          <a href="/logout.php">Logout
            <span class="expander" aria-hidden="true"></span>
          </a>
          <ul class="sub-menu" role="menu">
            <li class="menu-item" role="menuitem">
              <a <?php if ( $page == 'Preferences' ) {echo 'class="active"';} ?> href="/preferences.php">Preferences</a>
            </li>
            <?php if ( $_SESSION[ 'admin' ] ) : ?>
              <li class="menu-item" role="menuitem">
                <a <?php if ( $page == 'Users' ) {echo 'class="active"';} ?> href="/users.php">Users</a>
              </li>
            <?php endif; ?>
          </ul>
          </li>
          <li>
            Welcome, <?php echo $_SESSION['name']; ?>
          </li>
        <?php else : ?>
          <li class="menu-item" role="menuitem">
            <a <?php if ( $page == 'Login' ) {echo 'class="active"';} ?> href="/login.php">Login</a>
          </li>
          <li class="menu-item" role="menuitem">
            <a <?php if ( $page == 'Register' ) {echo 'class="active"';} ?> href="/register.php">Register</a>
          </li>
        <?php endif; ?>
        
        
        
      </ul>
    </div>
  
  </div>
  
  <button id="menu-toggle" class="menu-toggle" aria-controls="site-navigation" aria-expanded="true">Menu</button>

</nav>