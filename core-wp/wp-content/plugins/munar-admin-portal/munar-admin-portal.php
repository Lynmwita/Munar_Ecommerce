<?php
/**
 * Plugin Name: Munar Luxury Atelier — Admin Operations Portal
 * Plugin URI: https://github.com/lynnaz/Munar_Ecommerce
 * Description: Bespoke role-based luxury retail operations platform for Munar Luxury Atelier featuring Command Center Dashboard, M-Pesa Verification Desk, Inventory Command Center, Low-Stock Alert System, Audit Trail, and Product Quality Control.
 * Version: 1.0.0
 * Author: Munar Haute Couture & Engineering Team
 * Author URI: https://nazlinemwita.co.ke
 * Text Domain: munar-admin-portal
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Munar_Admin_Portal {

    public static function init() {
        // Admin menus
        add_action( 'admin_menu', array( __CLASS__, 'register_admin_menus' ), 9 );
        
        // Admin bar badge & quick links
        add_action( 'admin_bar_menu', array( __CLASS__, 'add_admin_bar_badges' ), 99 );

        // Enqueue custom luxury admin styling
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_admin_assets' ) );

        // AJAX handlers
        add_action( 'wp_ajax_munar_verify_mpesa_payment', array( __CLASS__, 'ajax_verify_mpesa' ) );
        add_action( 'wp_ajax_munar_adjust_stock', array( __CLASS__, 'ajax_adjust_stock' ) );
        add_action( 'wp_ajax_munar_quick_status_change', array( __CLASS__, 'ajax_quick_status' ) );

        // Role restriction for Store Manager
        add_action( 'admin_init', array( __CLASS__, 'enforce_role_permissions' ) );

        // Redirect Store Manager to Munar Operations on login
        add_filter( 'login_redirect', array( __CLASS__, 'custom_login_redirect' ), 10, 3 );
    }

    /**
     * Register Bespoke Admin Menus
     */
    public static function register_admin_menus() {
        // Count low stock items (<= 2 units) and pending M-Pesa verifications for menu badge
        $pending_count = self::get_pending_verification_count();
        $low_stock_count = self::get_low_stock_count();
        $total_alerts = $pending_count + $low_stock_count;

        $badge_html = $total_alerts > 0 ? sprintf( ' <span class="update-plugins count-%d"><span class="plugin-count">%d</span></span>', $total_alerts, $total_alerts ) : '';

        // Main Top-Level Menu
        add_menu_page(
            __( 'Munar Atelier Operations', 'munar-admin-portal' ),
            __( 'Munar Operations', 'munar-admin-portal' ) . $badge_html,
            'manage_woocommerce',
            'munar-operations',
            array( __CLASS__, 'render_command_center' ),
            'dashicons-superhero-alt',
            2
        );

        // Submenus
        add_submenu_page(
            'munar-operations',
            __( 'Command Center', 'munar-admin-portal' ),
            __( 'Command Center', 'munar-admin-portal' ),
            'manage_woocommerce',
            'munar-operations',
            array( __CLASS__, 'render_command_center' )
        );

        $mpesa_badge = $pending_count > 0 ? sprintf( ' <span class="awaiting-mod count-%d"><span class="pending-count">%d</span></span>', $pending_count, $pending_count ) : '';
        add_submenu_page(
            'munar-operations',
            __( 'M-Pesa Verification Desk', 'munar-admin-portal' ),
            __( 'M-Pesa Desk', 'munar-admin-portal' ) . $mpesa_badge,
            'manage_woocommerce',
            'munar-mpesa-desk',
            array( __CLASS__, 'render_mpesa_desk' )
        );

        $stock_badge = $low_stock_count > 0 ? sprintf( ' <span class="awaiting-mod count-%d"><span class="pending-count">%d</span></span>', $low_stock_count, $low_stock_count ) : '';
        add_submenu_page(
            'munar-operations',
            __( 'Inventory & Stock Alerts', 'munar-admin-portal' ),
            __( 'Inventory Center', 'munar-admin-portal' ) . $stock_badge,
            'manage_woocommerce',
            'munar-inventory',
            array( __CLASS__, 'render_inventory_center' )
        );

        add_submenu_page(
            'munar-operations',
            __( 'Stock Movement & Audit Trail', 'munar-admin-portal' ),
            __( 'Audit Trail', 'munar-admin-portal' ),
            'manage_woocommerce',
            'munar-audit-trail',
            array( __CLASS__, 'render_audit_trail' )
        );

        add_submenu_page(
            'munar-operations',
            __( 'Product Quality Control', 'munar-admin-portal' ),
            __( 'Catalog QC', 'munar-admin-portal' ),
            'manage_woocommerce',
            'munar-product-qc',
            array( __CLASS__, 'render_product_qc' )
        );

        add_submenu_page(
            'munar-operations',
            __( 'Patron Intelligence & LTV', 'munar-admin-portal' ),
            __( 'Patron Directory', 'munar-admin-portal' ),
            'manage_woocommerce',
            'munar-patrons',
            array( __CLASS__, 'render_patrons_directory' )
        );
    }

    /**
     * Admin Assets
     */
    public static function enqueue_admin_assets( $hook ) {
        if ( strpos( $hook, 'munar-' ) === false ) {
            return;
        }

        wp_enqueue_script( 'jquery' );
        wp_enqueue_style( 'munar-admin-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap', array(), null );
    }

    /**
     * Enforce Least Privilege on Store Manager
     */
    public static function enforce_role_permissions() {
        if ( ! current_user_can( 'administrator' ) && current_user_can( 'shop_manager' ) ) {
            // Remove sensitive core administration menus
            remove_menu_page( 'options-general.php' ); // Settings
            remove_menu_page( 'plugins.php' );         // Plugins
            remove_menu_page( 'themes.php' );          // Appearance
            remove_menu_page( 'users.php' );           // Users
            remove_menu_page( 'tools.php' );           // Tools
            remove_menu_page( 'edit-comments.php' );   // Comments
            remove_submenu_page( 'woocommerce', 'wc-settings' ); // WC core settings
        }
    }

    /**
     * Custom Login Redirect for Store Manager
     */
    public static function custom_login_redirect( $redirect_to, $request, $user ) {
        if ( isset( $user->roles ) && is_array( $user->roles ) ) {
            if ( in_array( 'shop_manager', $user->roles ) ) {
                return admin_url( 'admin.php?page=munar-operations' );
            }
        }
        return $redirect_to;
    }

    /**
     * Top Admin Bar Notifications
     */
    public static function add_admin_bar_badges( $admin_bar ) {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        $pending = self::get_pending_verification_count();
        $low_stock = self::get_low_stock_count();

        if ( $pending > 0 ) {
            $admin_bar->add_menu( array(
                'id'    => 'munar-mpesa-alert',
                'title' => sprintf( '⚡ <span style="background:#047857; color:#fff; padding:2px 8px; border-radius:10px; font-weight:bold; font-size:11px;">%d M-Pesa To Verify</span>', $pending ),
                'href'  => admin_url( 'admin.php?page=munar-mpesa-desk' ),
                'meta'  => array( 'title' => 'Orders awaiting Lipa na M-Pesa payment confirmation' ),
            ) );
        }

        if ( $low_stock > 0 ) {
            $admin_bar->add_menu( array(
                'id'    => 'munar-stock-alert',
                'title' => sprintf( '⚠ <span style="background:#D97706; color:#fff; padding:2px 8px; border-radius:10px; font-weight:bold; font-size:11px;">%d Low Stock (≤2)</span>', $low_stock ),
                'href'  => admin_url( 'admin.php?page=munar-inventory&filter=low_stock' ),
                'meta'  => array( 'title' => 'Products at or below 2 units' ),
            ) );
        }
    }

    // =========================================================================
    // 1. COMMAND CENTER DASHBOARD
    // =========================================================================
    public static function render_command_center() {
        $today = date( 'Y-m-d' );
        
        // Fetch Today's Orders
        $today_orders = wc_get_orders( array(
            'date_created' => '>=' . $today . ' 00:00:00',
            'limit'        => -1,
        ) );

        $today_rev = 0;
        foreach ( $today_orders as $o ) {
            if ( ! in_array( $o->get_status(), array( 'cancelled', 'failed', 'refunded' ) ) ) {
                $today_rev += (float) $o->get_total();
            }
        }

        $pending_count   = self::get_pending_verification_count();
        $processing_count = count( wc_get_orders( array( 'status' => 'processing', 'limit' => -1 ) ) );
        $completed_count  = count( wc_get_orders( array( 'status' => 'completed', 'limit' => -1 ) ) );
        $low_stock_count  = self::get_low_stock_count();
        $out_stock_count  = self::get_out_of_stock_count();
        $total_customers  = count_users()['avail_roles']['customer'] ?? 0;

        self::render_admin_styles();
        ?>
        <div class="wrap munar-admin-wrap">
            
            <!-- Luxury Header -->
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Munar Luxury Atelier</span>
                    <h1>Operations Command Center</h1>
                    <p>Real-time retail management, stock control, and M-Pesa order verification.</p>
                </div>
                <div class="munar-header-right">
                    <div class="munar-user-chip">
                        <span class="dot-online"></span>
                        <span><?php echo esc_html( wp_get_current_user()->display_name ); ?> (<?php echo esc_html( implode( ', ', wp_get_current_user()->roles ) ); ?>)</span>
                    </div>
                </div>
            </div>

            <!-- Quick Action Toolbar -->
            <div class="munar-quick-actions">
                <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>" class="btn-munar-action">
                    <span class="dashicons dashicons-plus-alt"></span> Add New Product
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-mpesa-desk' ) ); ?>" class="btn-munar-action <?php echo $pending_count > 0 ? 'action-highlight' : ''; ?>">
                    <span class="dashicons dashicons-money-alt"></span> M-Pesa Verification Desk (<?php echo esc_html( $pending_count ); ?>)
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory&filter=low_stock' ) ); ?>" class="btn-munar-action <?php echo $low_stock_count > 0 ? 'action-warning' : ''; ?>">
                    <span class="dashicons dashicons-warning"></span> Low Stock Center (<?php echo esc_html( $low_stock_count ); ?>)
                </a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>" class="btn-munar-action">
                    <span class="dashicons dashicons-cart"></span> View All Orders
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-product-qc' ) ); ?>" class="btn-munar-action">
                    <span class="dashicons dashicons-yes-alt"></span> Catalog Quality Checklist
                </a>
                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_coupon' ) ); ?>" class="btn-munar-action">
                    <span class="dashicons dashicons-tag"></span> Manage Coupons
                </a>
            </div>

            <!-- Operational Metric KPI Cards -->
            <div class="munar-stats-grid">
                
                <div class="munar-stat-card">
                    <div class="stat-label">Today's Revenue</div>
                    <div class="stat-value">KSh <?php echo esc_html( number_format( $today_rev, 2 ) ); ?></div>
                    <div class="stat-meta"><?php echo count( $today_orders ); ?> order(s) placed today</div>
                </div>

                <div class="munar-stat-card <?php echo $pending_count > 0 ? 'card-alert-green' : ''; ?>">
                    <div class="stat-label">M-Pesa Verifications Awaiting</div>
                    <div class="stat-value"><?php echo esc_html( $pending_count ); ?></div>
                    <div class="stat-meta">Direct transfers requiring verification</div>
                </div>

                <div class="munar-stat-card">
                    <div class="stat-label">Orders In Production</div>
                    <div class="stat-value"><?php echo esc_html( $processing_count ); ?></div>
                    <div class="stat-meta">Currently being tailored / packed</div>
                </div>

                <div class="munar-stat-card <?php echo $low_stock_count > 0 ? 'card-alert-orange' : ''; ?>">
                    <div class="stat-label">Low Stock Alerts (≤ 2 units)</div>
                    <div class="stat-value"><?php echo esc_html( $low_stock_count ); ?></div>
                    <div class="stat-meta">Approaching depletion threshold</div>
                </div>

                <div class="munar-stat-card <?php echo $out_stock_count > 0 ? 'card-alert-red' : ''; ?>">
                    <div class="stat-label">Out of Stock Pieces</div>
                    <div class="stat-value"><?php echo esc_html( $out_stock_count ); ?></div>
                    <div class="stat-meta">Needs workshop restock</div>
                </div>

                <div class="munar-stat-card">
                    <div class="stat-label">Completed Orders</div>
                    <div class="stat-value"><?php echo esc_html( $completed_count ); ?></div>
                    <div class="stat-meta">Delivered & verified patrons</div>
                </div>

            </div>

            <!-- Two-Column Operational Layout -->
            <div class="munar-split-grid">
                
                <!-- Left: Orders Requiring Attention -->
                <div class="munar-card-box">
                    <div class="box-header">
                        <h2>⚡ Orders Requiring Attention</h2>
                        <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>" class="box-link">All Orders &rarr;</a>
                    </div>
                    
                    <?php
                    $attention_orders = wc_get_orders( array(
                        'status' => array( 'on-hold', 'pending', 'processing', 'failed' ),
                        'limit'  => 6,
                    ) );

                    if ( ! empty( $attention_orders ) ) :
                    ?>
                        <table class="munar-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Patron</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $attention_orders as $o ) : 
                                    $o_id = $o->get_id();
                                    $status = $o->get_status();
                                    $phone = $o->get_meta( '_munar_mpesa_sender_phone' ) ?: $o->get_billing_phone();
                                    $code = $o->get_meta( '_munar_mpesa_receipt_code' );
                                ?>
                                    <tr id="order-row-<?php echo esc_attr( $o_id ); ?>">
                                        <td>
                                            <strong>#MNR-<?php echo esc_html( $o_id ); ?></strong><br>
                                            <span class="text-muted"><?php echo esc_html( $o->get_date_created()->date( 'M j, H:i' ) ); ?></span>
                                        </td>
                                        <td>
                                            <strong><?php echo esc_html( $o->get_formatted_billing_full_name() ?: 'Patron' ); ?></strong><br>
                                            <span class="text-muted"><?php echo esc_html( $phone ); ?></span>
                                        </td>
                                        <td>
                                            <strong>KSh <?php echo esc_html( number_format( (float) $o->get_total(), 2 ) ); ?></strong>
                                            <?php if ( $code ) : ?>
                                                <br><span class="code-badge"><?php echo esc_html( $code ); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo esc_attr( $status ); ?>">
                                                <?php echo esc_html( wc_get_order_status_name( $status ) ); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="row-actions-cluster">
                                                <?php if ( in_array( $status, array( 'on-hold', 'pending' ) ) ) : ?>
                                                    <button class="btn-verify-quick" data-order-id="<?php echo esc_attr( $o_id ); ?>">
                                                        ✓ Verify M-Pesa
                                                    </button>
                                                <?php elseif ( 'processing' === $status ) : ?>
                                                    <button class="btn-complete-quick" data-order-id="<?php echo esc_attr( $o_id ); ?>">
                                                        ✓ Mark Delivered
                                                    </button>
                                                <?php endif; ?>
                                                <a href="<?php echo esc_url( $o->get_edit_order_url() ); ?>" class="btn-view-order">
                                                    Open
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="munar-empty-state">
                            <span class="dashicons dashicons-yes-alt" style="font-size:32px; color:#047857; margin-bottom:8px;"></span>
                            <p>No orders require immediate attention. All current orders are processed or completed.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Low Stock Alerts & Inventory Health -->
                <div class="munar-card-box">
                    <div class="box-header">
                        <h2>⚠ Inventory Health & Low Stock (≤ 2 units)</h2>
                        <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory' ) ); ?>" class="box-link">Inventory Center &rarr;</a>
                    </div>

                    <?php
                    $low_stock_products = self::get_low_stock_products( 6 );
                    if ( ! empty( $low_stock_products ) ) :
                    ?>
                        <div class="munar-stock-list">
                            <?php foreach ( $low_stock_products as $prod ) : 
                                $p_id = $prod->get_id();
                                $stock = (int) $prod->get_stock_quantity();
                            ?>
                                <div class="stock-item-row" id="stock-item-<?php echo esc_attr( $p_id ); ?>">
                                    <div class="stock-item-info">
                                        <h4><?php echo esc_html( $prod->get_name() ); ?></h4>
                                        <p>SKU: <code><?php echo esc_html( $prod->get_sku() ?: 'N/A' ); ?></code> &bull; Price: KSh <?php echo esc_html( number_format( (float) $prod->get_price(), 2 ) ); ?></p>
                                    </div>
                                    <div class="stock-item-controls">
                                        <span class="stock-pill <?php echo $stock === 0 ? 'pill-out' : 'pill-low'; ?>">
                                            <?php echo $stock === 0 ? 'Out of Stock' : $stock . ' Left (≤2)'; ?>
                                        </span>
                                        <button class="btn-quick-adjust" data-product-id="<?php echo esc_attr( $p_id ); ?>" data-current="<?php echo esc_attr( $stock ); ?>">
                                            + Restock
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="munar-empty-state">
                            <span class="dashicons dashicons-shield-alt" style="font-size:32px; color:#047857; margin-bottom:8px;"></span>
                            <p>Inventory looks healthy! No products are currently below the 2-unit threshold.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

        </div>

        <?php self::render_admin_scripts(); ?>
        <?php
    }

    // =========================================================================
    // 2. M-PESA PAYMENT VERIFICATION DESK
    // =========================================================================
    public static function render_mpesa_desk() {
        self::render_admin_styles();
        
        $pending_orders = wc_get_orders( array(
            'status' => array( 'on-hold', 'pending' ),
            'limit'  => -1,
        ) );
        ?>
        <div class="wrap munar-admin-wrap">
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Safaricom Direct Transfer & Pochi</span>
                    <h1>M-Pesa Payment Verification Desk</h1>
                    <p>Verify customer M-Pesa Send Money payments made to <strong>0112855069</strong> (Munar Luxury Atelier) before authorizing production.</p>
                </div>
            </div>

            <div class="munar-card-box">
                <div class="box-header">
                    <h2>Orders Awaiting M-Pesa Verification (<?php echo count( $pending_orders ); ?>)</h2>
                </div>

                <?php if ( ! empty( $pending_orders ) ) : ?>
                    <table class="munar-table">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Patron Name & Contact</th>
                                <th>Transfer Amount</th>
                                <th>Provided M-Pesa Code</th>
                                <th>Date & Time</th>
                                <th>Verification Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $pending_orders as $o ) : 
                                $o_id = $o->get_id();
                                $phone = $o->get_meta( '_munar_mpesa_sender_phone' ) ?: $o->get_billing_phone();
                                $code = $o->get_meta( '_munar_mpesa_receipt_code' );
                                $total = number_format( (float) $o->get_total(), 2 );
                            ?>
                                <tr id="order-row-<?php echo esc_attr( $o_id ); ?>">
                                    <td>
                                        <a href="<?php echo esc_url( $o->get_edit_order_url() ); ?>" class="order-id-link">
                                            <strong>#MNR-<?php echo esc_html( $o_id ); ?></strong>
                                        </a>
                                    </td>
                                    <td>
                                        <strong><?php echo esc_html( $o->get_formatted_billing_full_name() ?: 'Patron' ); ?></strong><br>
                                        <span>Phone: <strong><?php echo esc_html( $phone ); ?></strong></span><br>
                                        <span class="text-muted"><?php echo esc_html( $o->get_billing_email() ); ?></span>
                                    </td>
                                    <td>
                                        <span class="amount-large">KSh <?php echo esc_html( $total ); ?></span>
                                    </td>
                                    <td>
                                        <?php if ( $code ) : ?>
                                            <span class="code-badge-large"><?php echo esc_html( $code ); ?></span>
                                        <?php else : ?>
                                            <span class="text-muted">Awaiting SMS code from patron</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html( $o->get_date_created()->date( 'M j, Y — H:i' ) ); ?>
                                    </td>
                                    <td>
                                        <div class="row-actions-cluster">
                                            <button class="btn-verify-large" data-order-id="<?php echo esc_attr( $o_id ); ?>">
                                                ✓ Verify & Advance to Processing
                                            </button>
                                            <a href="https://wa.me/<?php echo esc_attr( preg_replace('/[^0-9]/', '', $phone) ); ?>?text=Hello%20<?php echo esc_attr( urlencode( $o->get_billing_first_name() ) ); ?>,%20this%20is%20Munar%20Atelier%20inquiring%20about%20Order%20%23MNR-<?php echo esc_attr( $o_id ); ?>%20(KSh%20<?php echo esc_attr( $total ); ?>)." target="_blank" class="btn-whatsapp-chat">
                                                WhatsApp Patron
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="munar-empty-state">
                        <span class="dashicons dashicons-yes-alt" style="font-size:36px; color:#047857; margin-bottom:12px;"></span>
                        <h3>All M-Pesa Payments Cleared!</h3>
                        <p>No orders are currently waiting for payment verification.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php self::render_admin_scripts(); ?>
        <?php
    }

    // =========================================================================
    // 3. INVENTORY COMMAND CENTER & RESTOCKING
    // =========================================================================
    public static function render_inventory_center() {
        self::render_admin_styles();

        $filter = isset( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'all';

        $args = array(
            'limit' => -1,
            'orderby' => 'name',
            'order' => 'ASC',
        );

        $products = wc_get_products( $args );

        if ( 'low_stock' === $filter ) {
            $products = array_filter( $products, function( $p ) {
                $qty = $p->get_stock_quantity();
                return ( $qty !== null && $qty <= 2 && $qty > 0 );
            } );
        } elseif ( 'out_of_stock' === $filter ) {
            $products = array_filter( $products, function( $p ) {
                return ( ! $p->is_in_stock() || $p->get_stock_quantity() === 0 );
            } );
        } elseif ( 'healthy' === $filter ) {
            $products = array_filter( $products, function( $p ) {
                $qty = $p->get_stock_quantity();
                return ( $qty === null || $qty > 2 );
            } );
        }
        ?>
        <div class="wrap munar-admin-wrap">
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Atelier Stock Command</span>
                    <h1>Inventory Command Center</h1>
                    <p>Monitor real-time atelier workshop inventory, adjust quantities, and log stock restocks.</p>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="munar-tab-bar">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory&filter=all' ) ); ?>" class="tab-item <?php echo 'all' === $filter ? 'tab-active' : ''; ?>">All Pieces</a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory&filter=low_stock' ) ); ?>" class="tab-item <?php echo 'low_stock' === $filter ? 'tab-active' : ''; ?>">
                    Low Stock (≤2 units) <span class="tab-count"><?php echo esc_html( self::get_low_stock_count() ); ?></span>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory&filter=out_of_stock' ) ); ?>" class="tab-item <?php echo 'out_of_stock' === $filter ? 'tab-active' : ''; ?>">
                    Out of Stock <span class="tab-count"><?php echo esc_html( self::get_out_of_stock_count() ); ?></span>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=munar-inventory&filter=healthy' ) ); ?>" class="tab-item <?php echo 'healthy' === $filter ? 'tab-active' : ''; ?>">Healthy Stock</a>
            </div>

            <div class="munar-card-box">
                <table class="munar-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Garment / Piece Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>Status</th>
                            <th>Restock Adjustment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $products as $p ) : 
                            $p_id = $p->get_id();
                            $qty = $p->get_stock_quantity();
                            $is_managed = $p->managing_stock();
                            $status = $p->get_stock_status();
                        ?>
                            <tr id="inv-row-<?php echo esc_attr( $p_id ); ?>">
                                <td style="width: 50px;">
                                    <?php echo $p->get_image( array( 44, 44 ), array( 'class' => 'munar-thumb-img' ) ); ?>
                                </td>
                                <td>
                                    <a href="<?php echo esc_url( get_edit_post_link( $p_id ) ); ?>" class="order-id-link">
                                        <strong><?php echo esc_html( $p->get_name() ); ?></strong>
                                    </a>
                                </td>
                                <td><code><?php echo esc_html( $p->get_sku() ?: 'MNR-' . $p_id ); ?></code></td>
                                <td><?php echo esc_html( wc_get_product_category_list( $p_id, ', ' ) ?: 'Couture' ); ?></td>
                                <td><strong>KSh <?php echo esc_html( number_format( (float) $p->get_price(), 2 ) ); ?></strong></td>
                                <td>
                                    <span id="qty-val-<?php echo esc_attr( $p_id ); ?>" class="stock-qty-display">
                                        <?php echo $qty !== null ? esc_html( $qty ) : 'Uncapped'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ( $qty !== null && $qty <= 2 && $qty > 0 ) : ?>
                                        <span class="stock-pill pill-low">Low Stock (≤2)</span>
                                    <?php elseif ( ! $p->is_in_stock() || $qty === 0 ) : ?>
                                        <span class="stock-pill pill-out">Out of Stock</span>
                                    <?php else : ?>
                                        <span class="stock-pill pill-ok">Healthy</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="adjust-control-wrap">
                                        <select id="reason-<?php echo esc_attr( $p_id ); ?>" class="select-reason">
                                            <option value="New Workshop Delivery">New Workshop Delivery</option>
                                            <option value="Inventory Count Correction">Inventory Count</option>
                                            <option value="Atelier Showroom Sample">Showroom Sample</option>
                                            <option value="Damaged / Fabric Defect">Damaged Stock</option>
                                        </select>
                                        <div class="adjust-input-group">
                                            <input type="number" id="adj-<?php echo esc_attr( $p_id ); ?>" value="5" class="input-adj-qty" />
                                            <button class="btn-save-adj" data-product-id="<?php echo esc_attr( $p_id ); ?>">
                                                + Apply
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php self::render_admin_scripts(); ?>
        <?php
    }

    // =========================================================================
    // 4. STOCK MOVEMENT & AUDIT TRAIL
    // =========================================================================
    public static function render_audit_trail() {
        self::render_admin_styles();
        $audit_logs = get_option( 'munar_inventory_audit_log', array() );
        $audit_logs = array_reverse( $audit_logs ); // Most recent first
        ?>
        <div class="wrap munar-admin-wrap">
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Operational Accountability</span>
                    <h1>Stock Movement & Audit Trail</h1>
                    <p>Permanent log of all inventory adjustments, supplier restocks, and operational events.</p>
                </div>
            </div>

            <div class="munar-card-box">
                <div class="box-header">
                    <h2>Recent Inventory Activity Log</h2>
                </div>

                <?php if ( ! empty( $audit_logs ) ) : ?>
                    <table class="munar-table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Product Name</th>
                                <th>Previous Stock</th>
                                <th>Change</th>
                                <th>New Stock</th>
                                <th>Reason</th>
                                <th>Staff Member</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( array_slice( $audit_logs, 0, 50 ) as $log ) : ?>
                                <tr>
                                    <td><?php echo esc_html( $log['date'] ); ?></td>
                                    <td><strong><?php echo esc_html( $log['product'] ); ?></strong></td>
                                    <td><?php echo esc_html( $log['prev'] ); ?></td>
                                    <td>
                                        <span class="change-tag <?php echo strpos($log['change'], '+') !== false ? 'tag-plus' : 'tag-minus'; ?>">
                                            <?php echo esc_html( $log['change'] ); ?>
                                        </span>
                                    </td>
                                    <td><strong><?php echo esc_html( $log['new'] ); ?></strong></td>
                                    <td><em><?php echo esc_html( $log['reason'] ); ?></em></td>
                                    <td><span class="user-chip-small"><?php echo esc_html( $log['user'] ); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="munar-empty-state">
                        <span class="dashicons dashicons-backup" style="font-size:32px; color:#6B7280; margin-bottom:8px;"></span>
                        <p>No manual stock adjustments recorded yet. Changes made in the Inventory Center will appear here.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    // =========================================================================
    // 5. CATALOG QUALITY CONTROL CHECKLIST
    // =========================================================================
    public static function render_product_qc() {
        self::render_admin_styles();
        $products = wc_get_products( array( 'limit' => -1 ) );
        ?>
        <div class="wrap munar-admin-wrap">
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Luxury Merchandising Standards</span>
                    <h1>Catalog Quality Control Checklist</h1>
                    <p>Audits every couture piece to ensure high-resolution images, pricing, SKUs, and rich descriptions are complete.</p>
                </div>
            </div>

            <div class="munar-card-box">
                <table class="munar-table">
                    <thead>
                        <tr>
                            <th>Piece</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Stock Set</th>
                            <th>Readiness Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $products as $p ) : 
                            $p_id = $p->get_id();
                            $has_img = has_post_thumbnail( $p_id ) || ! empty( get_post_meta( $p_id, '_munar_hero_image_url', true ) );
                            $has_price = (float) $p->get_price() > 0;
                            $has_sku = ! empty( $p->get_sku() );
                            $has_cat = ! empty( wc_get_product_category_list( $p_id ) );
                            $has_desc = ! empty( $p->get_description() ) || ! empty( $p->get_short_description() );
                            $has_stock = $p->managing_stock() || $p->get_stock_status() === 'instock';

                            $is_complete = $has_img && $has_price && $has_sku && $has_cat && $has_desc;
                        ?>
                            <tr>
                                <td><strong><?php echo esc_html( $p->get_name() ); ?></strong></td>
                                <td><?php echo $has_img ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗ Missing</span>'; ?></td>
                                <td><?php echo $has_price ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗ Missing</span>'; ?></td>
                                <td><?php echo $has_sku ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗ Missing</span>'; ?></td>
                                <td><?php echo $has_cat ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗ Missing</span>'; ?></td>
                                <td><?php echo $has_desc ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗ Missing</span>'; ?></td>
                                <td><?php echo $has_stock ? '<span class="qc-check">✓</span>' : '<span class="qc-fail">✗</span>'; ?></td>
                                <td>
                                    <?php if ( $is_complete ) : ?>
                                        <span class="status-badge status-completed">Ready for Runway</span>
                                    <?php else : ?>
                                        <span class="status-badge status-failed">Needs Attention</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo esc_url( get_edit_post_link( $p_id ) ); ?>" class="btn-view-order">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    // =========================================================================
    // 6. PATRON DIRECTORY & LTV INTELLIGENCE
    // =========================================================================
    public static function render_patrons_directory() {
        self::render_admin_styles();
        $orders = wc_get_orders( array( 'limit' => -1 ) );
        
        $patrons = array();
        foreach ( $orders as $o ) {
            $email = $o->get_billing_email();
            if ( ! $email ) continue;

            if ( ! isset( $patrons[$email] ) ) {
                $patrons[$email] = array(
                    'name'       => $o->get_formatted_billing_full_name() ?: 'Patron',
                    'email'      => $email,
                    'phone'      => $o->get_billing_phone(),
                    'orders'     => 0,
                    'total_spent'=> 0,
                    'last_order' => $o->get_date_created()->date('M j, Y'),
                );
            }
            $patrons[$email]['orders']++;
            if ( ! in_array( $o->get_status(), array( 'cancelled', 'failed', 'refunded' ) ) ) {
                $patrons[$email]['total_spent'] += (float) $o->get_total();
            }
        }
        ?>
        <div class="wrap munar-admin-wrap">
            <div class="munar-header-bar">
                <div class="munar-header-left">
                    <span class="munar-badge">Clientele & VIP Relations</span>
                    <h1>Patron Directory & Lifetime Value (LTV)</h1>
                    <p>Overview of atelier clientele, purchase histories, and VIP loyalty tiers.</p>
                </div>
            </div>

            <div class="munar-card-box">
                <table class="munar-table">
                    <thead>
                        <tr>
                            <th>Patron Name</th>
                            <th>Email</th>
                            <th>Safaricom Phone</th>
                            <th>Total Orders</th>
                            <th>Lifetime Value (LTV)</th>
                            <th>Last Purchase</th>
                            <th>Tier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ( $patrons as $p ) : ?>
                            <tr>
                                <td><strong><?php echo esc_html( $p['name'] ); ?></strong></td>
                                <td><?php echo esc_html( $p['email'] ); ?></td>
                                <td><code><?php echo esc_html( $p['phone'] ); ?></code></td>
                                <td><strong><?php echo esc_html( $p['orders'] ); ?> order(s)</strong></td>
                                <td><strong class="amount-large">KSh <?php echo esc_html( number_format( $p['total_spent'], 2 ) ); ?></strong></td>
                                <td><?php echo esc_html( $p['last_order'] ); ?></td>
                                <td>
                                    <?php if ( $p['total_spent'] >= 50000 ) : ?>
                                        <span class="tier-badge tier-gold">VIP Atelier Circle</span>
                                    <?php else : ?>
                                        <span class="tier-badge tier-silver">Patron</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }

    // =========================================================================
    // AJAX ACTIONS
    // =========================================================================
    public static function ajax_verify_mpesa() {
        check_ajax_referer( 'munar_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error( 'Permission denied.' );
        }

        $order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
        $order = wc_get_order( $order_id );

        if ( ! $order ) {
            wp_send_json_error( 'Order not found.' );
        }

        $user = wp_get_current_user()->display_name;
        $order->payment_complete();
        $order->update_status( 'processing', sprintf( __( 'Payment manually verified on M-Pesa desk by %s.', 'munar-admin-portal' ), $user ) );
        $order->add_order_note( sprintf( __( 'Lipa na M-Pesa transfer confirmed by staff: %s', 'munar-admin-portal' ), $user ) );
        $order->save();

        // Log to audit
        self::log_audit( 'Payment Verified', '#' . $order_id, 'Status updated: On Hold -> Processing', $user );

        wp_send_json_success( array( 'message' => 'Payment verified successfully!' ) );
    }

    public static function ajax_adjust_stock() {
        check_ajax_referer( 'munar_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error( 'Permission denied.' );
        }

        $product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
        $adjustment = isset( $_POST['adjustment'] ) ? intval( $_POST['adjustment'] ) : 0;
        $reason     = isset( $_POST['reason'] ) ? sanitize_text_field( $_POST['reason'] ) : 'Manual update';

        $product = wc_get_product( $product_id );
        if ( ! $product ) {
            wp_send_json_error( 'Product not found.' );
        }

        $product->set_manage_stock( true );
        $prev_qty = (int) $product->get_stock_quantity();
        $new_qty = max( 0, $prev_qty + $adjustment );
        $product->set_stock_quantity( $new_qty );
        $product->set_stock_status( $new_qty > 0 ? 'instock' : 'outofstock' );
        $product->save();

        $user = wp_get_current_user()->display_name;
        $change_str = ($adjustment >= 0 ? '+' : '') . $adjustment . ' units';

        self::log_audit( $product->get_name(), $prev_qty, $change_str, $new_qty, $reason, $user );

        wp_send_json_success( array(
            'new_qty' => $new_qty,
            'status'  => $new_qty > 0 ? 'instock' : 'outofstock',
        ) );
    }

    public static function ajax_quick_status() {
        check_ajax_referer( 'munar_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            wp_send_json_error( 'Permission denied.' );
        }

        $order_id = isset( $_POST['order_id'] ) ? absint( $_POST['order_id'] ) : 0;
        $new_status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : 'completed';
        $order = wc_get_order( $order_id );

        if ( $order ) {
            $user = wp_get_current_user()->display_name;
            $order->update_status( $new_status, sprintf( __( 'Status updated to %s by %s.', 'munar-admin-portal' ), $new_status, $user ) );
            self::log_audit( 'Order Status Change', '#' . $order_id, 'Status changed to ' . $new_status, $user );
            wp_send_json_success();
        }
        wp_send_json_error();
    }

    private static function log_audit( $product, $prev = '', $change = '', $new = '', $reason = '', $user = '' ) {
        $logs = get_option( 'munar_inventory_audit_log', array() );
        $logs[] = array(
            'date'    => current_time( 'mysql' ),
            'product' => $product,
            'prev'    => $prev,
            'change'  => $change,
            'new'     => $new,
            'reason'  => $reason,
            'user'    => $user ?: wp_get_current_user()->display_name,
        );
        // Keep last 200 logs
        if ( count( $logs ) > 200 ) {
            $logs = array_slice( $logs, -200 );
        }
        update_option( 'munar_inventory_audit_log', $logs );
    }

    // =========================================================================
    // HELPER METHODS
    // =========================================================================
    private static function get_pending_verification_count() {
        return count( wc_get_orders( array(
            'status' => array( 'on-hold', 'pending' ),
            'limit'  => -1,
        ) ) );
    }

    private static function get_low_stock_count() {
        $products = wc_get_products( array( 'limit' => -1 ) );
        $count = 0;
        foreach ( $products as $p ) {
            $qty = $p->get_stock_quantity();
            if ( $qty !== null && $qty <= 2 && $qty > 0 ) {
                $count++;
            }
        }
        return $count;
    }

    private static function get_out_of_stock_count() {
        $products = wc_get_products( array( 'limit' => -1 ) );
        $count = 0;
        foreach ( $products as $p ) {
            if ( ! $p->is_in_stock() || $p->get_stock_quantity() === 0 ) {
                $count++;
            }
        }
        return $count;
    }

    private static function get_low_stock_products( $limit = 10 ) {
        $products = wc_get_products( array( 'limit' => -1 ) );
        $low_stock = array();
        foreach ( $products as $p ) {
            $qty = $p->get_stock_quantity();
            if ( ( $qty !== null && $qty <= 2 ) || ! $p->is_in_stock() ) {
                $low_stock[] = $p;
                if ( count( $low_stock ) >= $limit ) break;
            }
        }
        return $low_stock;
    }

    // =========================================================================
    // LUXURY ADMIN STYLES & JS
    // =========================================================================
    public static function render_admin_styles() {
        ?>
        <style>
            :root {
                --munar-black: #0d0d0d;
                --munar-mocha: #4a2f24;
                --munar-linen: #ebdccb;
                --munar-cream: #faf7f2;
                --munar-gold: #c5a880;
                --munar-border: #e6dfd5;
            }
            .munar-admin-wrap {
                font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
                margin-top: 20px;
                padding-right: 20px;
                color: #1a1a1a;
            }
            .munar-header-bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: linear-gradient(135deg, #0d0d0d 0%, #1f1815 100%);
                color: #faf7f2;
                padding: 24px 32px;
                border-radius: 4px;
                margin-bottom: 24px;
                border-left: 5px solid #c5a880;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            }
            .munar-header-left h1 {
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: 2.2rem;
                font-weight: 500;
                color: #faf7f2;
                margin: 4px 0 6px 0;
                letter-spacing: 0.05em;
            }
            .munar-header-left p {
                margin: 0;
                font-size: 0.85rem;
                color: #ebdccb;
                opacity: 0.85;
            }
            .munar-badge {
                font-size: 0.65rem;
                text-transform: uppercase;
                letter-spacing: 0.25em;
                color: #c5a880;
                font-weight: 700;
            }
            .munar-user-chip {
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.15);
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 0.8rem;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .dot-online {
                width: 8px;
                height: 8px;
                background: #10b981;
                border-radius: 50%;
                display: inline-block;
            }

            /* Quick Action Buttons */
            .munar-quick-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-bottom: 24px;
            }
            .btn-munar-action {
                background: #ffffff;
                border: 1px solid var(--munar-border);
                color: #0d0d0d;
                padding: 10px 18px;
                border-radius: 3px;
                text-decoration: none;
                font-size: 0.8125rem;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: all 0.2s;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            }
            .btn-munar-action:hover {
                background: #0d0d0d;
                color: #ffffff;
                border-color: #0d0d0d;
            }
            .btn-munar-action.action-highlight {
                background: #047857;
                color: #ffffff;
                border-color: #047857;
            }
            .btn-munar-action.action-warning {
                background: #d97706;
                color: #ffffff;
                border-color: #d97706;
            }

            /* Stats KPI Grid */
            .munar-stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 16px;
                margin-bottom: 28px;
            }
            .munar-stat-card {
                background: #ffffff;
                border: 1px solid var(--munar-border);
                padding: 20px;
                border-radius: 3px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.03);
                transition: transform 0.2s ease;
            }
            .munar-stat-card:hover {
                transform: translateY(-2px);
            }
            .stat-label {
                font-size: 0.72rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                color: #6b7280;
                font-weight: 600;
                margin-bottom: 6px;
            }
            .stat-value {
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: 2rem;
                font-weight: 600;
                color: #0d0d0d;
                line-height: 1.1;
                margin-bottom: 4px;
            }
            .stat-meta {
                font-size: 0.75rem;
                color: #9ca3af;
            }
            .card-alert-green { border-top: 3px solid #047857; }
            .card-alert-orange { border-top: 3px solid #d97706; }
            .card-alert-red { border-top: 3px solid #dc2626; }

            /* Two Column Layout */
            .munar-split-grid {
                display: grid;
                grid-template-columns: 1.4fr 1fr;
                gap: 24px;
            }
            @media(max-width: 1024px) {
                .munar-split-grid { grid-template-columns: 1fr; }
            }
            .munar-card-box {
                background: #ffffff;
                border: 1px solid var(--munar-border);
                border-radius: 3px;
                padding: 24px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.04);
                margin-bottom: 24px;
            }
            .box-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-bottom: 14px;
                border-bottom: 1px solid #f0ebe1;
                margin-bottom: 18px;
            }
            .box-header h2 {
                font-family: 'Cormorant Garamond', Georgia, serif;
                font-size: 1.4rem;
                font-weight: 600;
                margin: 0;
                color: #0d0d0d;
            }
            .box-link {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #c5a880;
                text-decoration: none;
                font-weight: 600;
            }

            /* Tables */
            .munar-table {
                width: 100%;
                border-collapse: collapse;
                text-align: left;
            }
            .munar-table th {
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.12em;
                color: #6b7280;
                padding: 10px 12px;
                border-bottom: 2px solid #0d0d0d;
            }
            .munar-table td {
                padding: 12px;
                border-bottom: 1px solid #f0ebe1;
                font-size: 0.8125rem;
                vertical-align: middle;
            }
            .munar-thumb-img {
                width: 44px;
                height: 44px;
                object-fit: cover;
                border-radius: 2px;
                border: 1px solid #e6dfd5;
            }

            /* Status & Badges */
            .status-badge {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .status-pending, .status-on-hold { background: #fef3c7; color: #92400e; }
            .status-processing { background: #dbeafe; color: #1e40af; }
            .status-completed { background: #d1fae5; color: #065f46; }
            .status-failed { background: #fee2e2; color: #991b1b; }

            .code-badge {
                background: #ecfdf5;
                color: #047857;
                padding: 2px 6px;
                border: 1px solid #a7f3d0;
                border-radius: 3px;
                font-size: 0.72rem;
                font-family: monospace;
            }
            .code-badge-large {
                background: #ecfdf5;
                color: #047857;
                padding: 4px 10px;
                border: 1px solid #a7f3d0;
                border-radius: 4px;
                font-size: 0.95rem;
                font-family: monospace;
                font-weight: bold;
            }
            .amount-large {
                font-weight: 700;
                color: #0d0d0d;
                font-size: 1rem;
            }

            /* Stock Pills */
            .stock-pill {
                display: inline-block;
                padding: 3px 8px;
                border-radius: 12px;
                font-size: 0.72rem;
                font-weight: 600;
            }
            .pill-low { background: #fef3c7; color: #b45309; }
            .pill-out { background: #fee2e2; color: #b91c1c; }
            .pill-ok { background: #e0e7ff; color: #3730a3; }

            /* Action Buttons */
            .btn-verify-quick, .btn-verify-large {
                background: #047857;
                color: #ffffff;
                border: none;
                padding: 6px 12px;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 3px;
                cursor: pointer;
                transition: background 0.2s;
            }
            .btn-verify-quick:hover, .btn-verify-large:hover { background: #065f46; }
            .btn-verify-large { padding: 8px 16px; font-size: 0.8125rem; }

            .btn-complete-quick {
                background: #0d0d0d;
                color: #ffffff;
                border: none;
                padding: 6px 12px;
                font-size: 0.75rem;
                font-weight: 600;
                border-radius: 3px;
                cursor: pointer;
            }
            .btn-view-order {
                background: #f3f4f6;
                color: #374151;
                padding: 5px 10px;
                font-size: 0.75rem;
                text-decoration: none;
                border-radius: 3px;
                border: 1px solid #d1d5db;
            }
            .btn-whatsapp-chat {
                background: #25d366;
                color: #ffffff;
                padding: 8px 14px;
                font-size: 0.75rem;
                font-weight: 600;
                text-decoration: none;
                border-radius: 3px;
                display: inline-block;
            }
            .btn-quick-adjust {
                background: #ffffff;
                border: 1px solid #d1d5db;
                padding: 4px 10px;
                font-size: 0.75rem;
                cursor: pointer;
                border-radius: 3px;
            }

            /* Inventory Adjust Controls */
            .adjust-control-wrap {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .select-reason {
                font-size: 0.72rem;
                padding: 2px 4px;
                height: 26px;
            }
            .adjust-input-group {
                display: flex;
                gap: 4px;
            }
            .input-adj-qty {
                width: 55px;
                height: 26px;
                font-size: 0.8rem;
                text-align: center;
            }
            .btn-save-adj {
                background: #0d0d0d;
                color: #ffffff;
                border: none;
                font-size: 0.72rem;
                padding: 0 8px;
                cursor: pointer;
                border-radius: 2px;
            }

            /* Tabs */
            .munar-tab-bar {
                display: flex;
                gap: 8px;
                margin-bottom: 16px;
                border-bottom: 1px solid #e5e7eb;
                padding-bottom: 8px;
            }
            .tab-item {
                padding: 8px 16px;
                text-decoration: none;
                color: #4b5563;
                font-size: 0.8125rem;
                font-weight: 600;
                border-radius: 4px;
            }
            .tab-item.tab-active {
                background: #0d0d0d;
                color: #ffffff;
            }
            .tab-count {
                background: rgba(0,0,0,0.15);
                padding: 1px 6px;
                border-radius: 10px;
                font-size: 0.7rem;
            }
            .tab-item.tab-active .tab-count {
                background: #c5a880;
                color: #0d0d0d;
            }

            /* QC Checklist */
            .qc-check { color: #047857; font-weight: bold; }
            .qc-fail { color: #dc2626; font-size: 0.75rem; }

            /* Empty States */
            .munar-empty-state {
                text-align: center;
                padding: 40px 20px;
                color: #6b7280;
                font-size: 0.875rem;
            }
        </style>
        <?php
    }

    public static function render_admin_scripts() {
        $nonce = wp_create_nonce( 'munar_admin_nonce' );
        ?>
        <script>
            jQuery(document).ready(function($) {
                var nonce = '<?php echo esc_js( $nonce ); ?>';

                // 1. Verify M-Pesa Payment
                $('.btn-verify-quick, .btn-verify-large').on('click', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var orderId = btn.data('order-id');
                    if (!confirm('Confirm Lipa na M-Pesa payment received for Order #' + orderId + '?')) return;

                    btn.prop('disabled', true).text('Verifying...');
                    $.post(ajaxurl, {
                        action: 'munar_verify_mpesa_payment',
                        order_id: orderId,
                        nonce: nonce
                    }, function(res) {
                        if (res.success) {
                            btn.replaceWith('<span class="status-badge status-completed">✓ Verified</span>');
                            $('#order-row-' + orderId + ' .status-badge').removeClass('status-on-hold status-pending').addClass('status-processing').text('Processing');
                        } else {
                            alert(res.data || 'Verification failed');
                            btn.prop('disabled', false).text('Verify M-Pesa');
                        }
                    });
                });

                // 2. Adjust Stock
                $('.btn-save-adj').on('click', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var pId = btn.data('product-id');
                    var adj = parseInt($('#adj-' + pId).val()) || 0;
                    var reason = $('#reason-' + pId).val();

                    btn.prop('disabled', true).text('...');
                    $.post(ajaxurl, {
                        action: 'munar_adjust_stock',
                        product_id: pId,
                        adjustment: adj,
                        reason: reason,
                        nonce: nonce
                    }, function(res) {
                        btn.prop('disabled', false).text('+ Apply');
                        if (res.success) {
                            $('#qty-val-' + pId).text(res.data.new_qty);
                            alert('Inventory updated! New stock: ' + res.data.new_qty + ' units.');
                        }
                    });
                });

                // 3. Mark Complete / Delivered
                $('.btn-complete-quick').on('click', function(e) {
                    e.preventDefault();
                    var btn = $(this);
                    var orderId = btn.data('order-id');

                    btn.prop('disabled', true).text('Updating...');
                    $.post(ajaxurl, {
                        action: 'munar_quick_status_change',
                        order_id: orderId,
                        status: 'completed',
                        nonce: nonce
                    }, function(res) {
                        if (res.success) {
                            btn.replaceWith('<span class="status-badge status-completed">✓ Delivered</span>');
                            $('#order-row-' + orderId + ' .status-badge').removeClass('status-processing').addClass('status-completed').text('Completed');
                        }
                    });
                });
            });
        </script>
        <?php
    }
}

Munar_Admin_Portal::init();
