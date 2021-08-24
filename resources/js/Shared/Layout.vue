<template>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <!-- <div
                class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top"
            >
                <a class="sidebar-brand brand-logo" href="index.html"
                    ><img src="images/logo.svg" alt="logo"
                /></a>
                <a class="sidebar-brand brand-logo-mini" href="index.html"
                    ><img src="images/logo-mini.svg" alt="logo"
                /></a>
            </div> -->
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img
                                    class="img-xs rounded-circle "
                                    src="images/faces/face15.jpg"
                                    alt=""
                                />
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">
                                    Admin
                                </h5>
                            </div>
                        </div>
                        
                    </div>
                </li>
                <li class="nav-item nav-category">
                    <span class="nav-link">Navigation</span>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('dashboard')"
                        @click="addActiveClass('dashboard')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('beacons')"
                        @click="addActiveClass('beacons')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-playlist-play"></i>
                        </span>
                        <span class="menu-title">Beacons</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('workers')"
                        @click="addActiveClass('workers')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-table-large"></i>
                        </span>
                        <span class="menu-title">Workers</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('customers')"
                        @click="addActiveClass('customers')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-chart-bar"></i>
                        </span>
                        <span class="menu-title">Customers</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('mould-models')"
                        @click="addActiveClass('mould-models')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-file-document-box"></i>
                        </span>
                        <span class="menu-title">Mould Models</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('orders')"
                        @click="addActiveClass('orders')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-contacts"></i>
                        </span>
                        <span class="menu-title">Orders</span>
                    </inertia-link>
                </li>
                <li class="nav-item menu-items">
                    <inertia-link
                        class="nav-link"
                        :href="route('orders-monitor')"
                        @click="addActiveClass('orders-monitor')"
                    >
                        <span class="menu-icon">
                            <i class="mdi mdi-contacts"></i>
                        </span>
                        <span class="menu-title">Orders Monitor</span>
                    </inertia-link>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div
                    class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center"
                >
                    <a class="navbar-brand brand-logo-mini" href="index.html"
                        ><img src="images/logo-mini.svg" alt="logo"
                    /></a>
                </div>
                <div
                    class="navbar-menu-wrapper flex-grow d-flex align-items-stretch"
                >
                    <button
                        class="navbar-toggler navbar-toggler align-self-center"
                        type="button"
                        data-toggle="minimize"
                    >
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link"
                                id="profileDropdown"
                                href="#"
                                data-toggle="dropdown"
                            >
                                <div class="navbar-profile">
                                    <img
                                        class="img-xs rounded-circle"
                                        src="images/faces/face15.jpg"
                                        alt=""
                                    />
                                    <p
                                        class="mb-0 d-none d-sm-block navbar-profile-name"
                                    >
                                        Admin
                                    </p>
                                    <i
                                        class="mdi mdi-menu-down d-none d-sm-block"
                                    ></i>
                                </div>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                aria-labelledby="profileDropdown"
                            >
                                <inertia-link
                                    class="dropdown-item preview-item"
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    type="button"
                                >
                                    <div class="preview-thumbnail">
                                        <div
                                            class="preview-icon bg-dark rounded-circle"
                                        >
                                            <i
                                                class="mdi mdi-logout text-danger"
                                            ></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">
                                            Logout
                                        </p>
                                    </div>
                                </inertia-link>
                            </div>
                        </li>
                    </ul>
                    <button
                        class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                        type="button"
                        data-toggle="offcanvas"
                    >
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>

            <!-- partial -->
            <div class="main-panel">
                <slot></slot>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</template>

<script>
export default {
    methods: {
        addActiveClass(route_name) {
            var curr = this.route(route_name).split("/").slice(-1)[0].replace(/^\/|\/$/g, "");

            function addActiveClass(element) {
                element.parents(".nav-item").last().removeClass("active");
                
                // var x = element.attr("href");
                var clicked = element.attr("href").split("/").slice(-1)[0].replace(/^\/|\/$/g, "");

                if (clicked == curr) {
                    element.parents(".nav-item").last().addClass("active");
                }

                // if (element.attr("href").indexOf(curr) !== -1) {
                //     element.parents(".nav-item").last().addClass("active");
                // }

                // if (element.attr("href").indexOf(curr) !== -1) {
                //     element.parents(".nav-item").last().addClass("active");
                //     if (element.parents(".sub-menu").length) {
                //         element.closest(".collapse").addClass("show");
                //         element.addClass("active");
                //     }
                //     if (element.parents(".submenu-item").length) {
                //         element.addClass("active");
                //     }
                // }
            }

            $(".nav li a", sidebar).each(function() {
                var $this = $(this);
                addActiveClass($this);
            });

            $(".horizontal-menu .nav li a").each(function() {
                var $this = $(this);
                addActiveClass($this);
            });
        }
    },
    mounted() {
        var body = $("body");
        $('[data-toggle="minimize"]').on("click", function() {
            if ( body.hasClass("sidebar-toggle-display") || body.hasClass("sidebar-absolute") ) {
                body.toggleClass("sidebar-hidden");
            } else {
                body.toggleClass("sidebar-icon-only");
            }
        });

        $('[data-toggle="offcanvas"]').on("click", function() {
            $('.sidebar-offcanvas').toggleClass('active')
        });

        // Keep menu tab active after refreshing page
        function addActiveClass2(element) {
            if (element.attr("href") == location.href) {
                element.parents(".nav-item").last().addClass("active");
                if (element.parents(".sub-menu").length) {
                    element.closest(".collapse").addClass("show");
                    element.addClass("active");
                }
                if (element.parents(".submenu-item").length) {
                    element.addClass("active");
                }
            }
        }

        $(".nav li a", sidebar).each(function() {
            var $this = $(this);
            addActiveClass2($this);
        });

        $(".horizontal-menu .nav li a").each(function() {
            var $this = $(this);
            addActiveClass2($this);
        });
    }
};
</script>
