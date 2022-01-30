const Login = ()=>{
    return (
        <div className="main-container">
            <section className="height-100 imagebg text-center" data-overlay="4">
                <div className="background-image-holder login-bg">
                    <img alt="background" src="/assets/img/inner-6.jpg"/>
                </div>
                <div className="container pos-vertical-center">
                    <div className="row">
                        <div className="col-md-7 col-lg-5">
                            <h2>Login to continue</h2>
                            <p className="lead">
                                Welcome back, sign in with your existing credentials
                            </p>
                            <form>
                                <div className="row">
                                    <div className="col-md-12">
                                        <input type="text" placeholder="Username"/>
                                    </div>
                                    <div className="col-md-12">
                                        <input type="password" placeholder="Password"/>
                                    </div>
                                    <div className="col-md-12">
                                        <button className="btn btn--primary type--uppercase" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                            <span className="type--fine-print block">Dont have an account yet?
                                <a href="page-accounts-create-1.html">Create account</a>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}

export default Login
