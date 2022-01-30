const Nav = ()=> {
    return(
        <div className="nav-container ">
            <nav id="menu1" className="bar bar--sm bar-1 hidden-xs ">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-1 col-md-2 hidden-xs">
                            <div className="bar__module">
                                <a href="index.html">
                                    <img className="logo logo-dark" alt="logo" src="img/logo-dark.png"/>
                                    <img className="logo logo-light" alt="logo" src="img/logo-light.png"/>
                                </a>
                            </div>
                        </div>
                        <div className="col-lg-11 col-md-12 text-right text-left-xs text-left-sm">
                            <div className="bar__module">
                                <ul className="menu-horizontal text-left">
                                    <li className="dropdown">
                                        <span className="dropdown__trigger">Home</span>
                                    </li>
                                    <li className="dropdown">
                                        <span className="dropdown__trigger">My Blog Posts</span>
                                    </li>
                                    <li className="dropdown">
                                        <span className="dropdown__trigger">Add New Post</span>
                                    </li>
                                    <li className="dropdown">
                                        <span className="dropdown__trigger">Logout</span>
                                    </li>
                                </ul>
                            </div>

                            <div className="bar__module">
                                <a className="btn btn--sm type--uppercase" href="variant/builder.html">
                                    <span className="btn__text">
                                        Login
                                    </span>
                                </a>
                                <a className="btn btn--sm btn--primary type--uppercase"
                                   href="https://themeforest.net/item/stack-multipurpose-html-with-page-builder/19337626?ref=medium_rare">
                                    <span className="btn__text">
                                        Sign up
                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </nav>
        </div>
    )
}

export default Nav;
