import {Link} from "react-router-dom";
import {logout} from "../services/requests";
import store from 'store'
import {AUTH_STORAGE_KEY} from "../constants";
import {useEffect, useState} from "react";

const Nav = ()=> {
    const [auth, setAuth] = useState()

    useEffect(()=>{
        setAuth(store.get(AUTH_STORAGE_KEY));
    }, []);

    const handleLogout = async (e)=>{
        e.preventDefault();
        const res = await logout();
        if(res.status === 200){
            store.set(AUTH_STORAGE_KEY, null);
            window.location = '/'
        }
    }
    return(
        <div className="nav-container ">
            <nav id="menu1" className="bar bar--sm bar-1 hidden-xs ">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-2 col-md-2 hidden-xs">
                            <div className="bar__module">
                                <Link to="/">
                                    <img className="logo-dark" alt="logo" src="assets/img/logo-dark.png"/>
                                    <img className="logo-light" alt="logo" src="assets/img/logo-dark.png"/>
                                </Link>
                            </div>
                        </div>
                        <div className="col-lg-10 col-md-12 text-right text-left-xs text-left-sm">
                            <div className="bar__module">
                                <ul className="menu-horizontal text-left">
                                    <li className="dropdown">
                                        <Link to="/">Home </Link>
                                    </li>
                                    {
                                        auth?.isLoggedIn && (
                                            <>
                                                <li className="dropdown">
                                                    <Link to="/user/my-posts">My Blog Posts </Link>
                                                </li>
                                                <li className="dropdown">
                                                    <Link to="/user/new-post">Add New Post </Link>
                                                </li>
                                                <li className="dropdown">
                                                    <a href="#" onClick={(e)=>handleLogout(e)}>Logout </a>
                                                </li>
                                            </>
                                        )
                                    }
                                </ul>
                            </div>

                            <div className="bar__module">
                                {
                                    !auth?.isLoggedIn && (
                                        <>
                                            <Link className="btn btn--sm type--uppercase" to="/auth/login">
                                                <span className="btn__text">
                                                    Login
                                                </span>
                                            </Link>
                                            <Link className="btn btn--sm btn--primary type--uppercase" to="/auth/register">
                                                <span className="btn__text">
                                                    Sign up
                                                </span>
                                            </Link>
                                        </>
                                    )
                                }

                            </div>

                        </div>
                    </div>

                </div>
            </nav>
        </div>
    )
}

export default Nav;
