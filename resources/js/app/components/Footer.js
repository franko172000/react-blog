const Footer = ()=> {
    return(
        <footer className="footer-3 text-center-xs space--xs ">
            <div className="container">
                <div className="row">
                    <div className="col-md-6">
                        <img alt="Image" className="logo" src="img/logo-dark.png"/>
                        <ul className="list-inline list--hover">
                            <li className="list-inline-item">
                                <a href="#">
                                    <span className="type--fine-print">Get Started</span>
                                </a>
                            </li>
                            <li className="list-inline-item">
                                <a href="#">
                                    <span className="type--fine-print">help@stack.io</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="col-md-6 text-right text-center-xs">
                        <ul className="social-list list-inline list--hover">
                            <li className="list-inline-item">
                                <a href="#">
                                    <i className="socicon socicon-google icon icon--xs"></i>
                                </a>
                            </li>
                            <li className="list-inline-item">
                                <a href="#">
                                    <i className="socicon socicon-twitter icon icon--xs"></i>
                                </a>
                            </li>
                            <li className="list-inline-item">
                                <a href="#">
                                    <i className="socicon socicon-facebook icon icon--xs"></i>
                                </a>
                            </li>
                            <li className="list-inline-item">
                                <a href="#">
                                    <i className="socicon socicon-instagram icon icon--xs"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6">
                        <p className="type--fine-print">
                            Supercharge your web workflow
                        </p>
                    </div>
                    <div className="col-md-6 text-right text-center-xs">
                            <span className="type--fine-print">&copy;
                                <span className="update-year"></span> Stack Inc.</span>
                        <a className="type--fine-print" href="#">Privacy Policy</a>
                        <a className="type--fine-print" href="#">Legal</a>
                    </div>
                </div>
            </div>
        </footer>
    )
}

export default Footer;
