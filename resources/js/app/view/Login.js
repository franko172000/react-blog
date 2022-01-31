import * as Yup from "yup";
import {yupResolver} from "@hookform/resolvers/yup";
import {useForm} from "react-hook-form";
import {useHttpError, useToast} from "../hooks";
import {Link, useNavigate} from "react-router-dom";
import store from 'store'
import {loginUser} from "../services/requests";
import {AUTH_STORAGE_KEY} from "../constants";

const Login = ()=>{
    const formValidationSchema = Yup.object().shape({
        email: Yup.string().required('email is required').email('email is invalid'),
        password: Yup.string().required('Password is required'),
    });

    const formOptions = { resolver: yupResolver(formValidationSchema)};
    // get functions to build form with useForm() hook
    const { register, handleSubmit, reset, formState } = useForm(formOptions);
    const { errors } = formState;
    const httpError = useHttpError();
    const toast = useToast();
    const navigate = useNavigate();

    const login = async (formData) => {
        try{
            const res = await loginUser(formData);
            const responseData = res.data.data;
            store.set(AUTH_STORAGE_KEY,{
                isLoggedIn: true,
                user: {
                    ...responseData
                }
            })
            toast("success", "Login successful!");
            window.location = "/user/my-posts"
        }catch(err){
            httpError(err)
        }
        return false;
    }

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
                            <form onSubmit={handleSubmit(login)}>
                                <div className="row">
                                    <div className="col-md-12">
                                        <input type="email" name="Email Address" className={errors.email ? 'input-error' : ''} {...register('email')} placeholder="Email Address"/>
                                        <span className="text-danger">{errors.email?.message}</span>
                                    </div>
                                    <div className="col-md-12">
                                        <input type="password" name="password" className={errors.password ? 'input-error' : ''} {...register('password')} placeholder="Password"/>
                                        <span className="text-danger">{errors.password?.message}</span>
                                    </div>
                                    <div className="col-md-12">
                                        <button className="btn btn--primary type--uppercase" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                            <span className="type--fine-print block">Dont have an account yet?
                                <Link to="/auth/register">Create account</Link>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}

export default Login
