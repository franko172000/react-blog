import Nav from "../components/Nav";
import { useForm } from "react-hook-form";
import { yupResolver } from '@hookform/resolvers/yup';
import * as Yup from 'yup';
import {createUser} from "../services/requests";
import {useHttpError, useToast} from "../hooks";
import {Link, useNavigate} from "react-router-dom";

const Register = ()=>{
    const formValidationSchema = Yup.object().shape({
        firstName: Yup.string().required('first name is required'),
        lastName: Yup.string().required('last name is required'),
        email: Yup.string().required('email is required').email('email is invalid'),
        password: Yup.string().matches("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})", 'Password not valid'),
    });

    const formOptions = { resolver: yupResolver(formValidationSchema)};
    // get functions to build form with useForm() hook
    const { register, handleSubmit, reset, formState } = useForm(formOptions);
    const { errors } = formState;
    const httpError = useHttpError();
    const toast = useToast();
    const navigate = useNavigate();

    const registerUser = async (data) => {
        try{
            await createUser(data);
            toast("success", "Thank you for creating an account. Please login to create your first post.");
            navigate('/auth/login')
        }catch (err){
            httpError(err);
        }

        return false;
    }
    return (
        <div className="main-container">
            <section className="imageblock switchable feature-large height-100">
                <div className="imageblock__content col-lg-6 col-md-4 pos-right">
                    <div className="background-image-holder register-bg">
                        <Nav />
                        <img alt="image" src="img/inner-7.jpg"/>
                    </div>
                </div>
                <div className="container pos-vertical-center">
                    <div className="row">
                        <div className="col-lg-5 col-md-7">
                            <h2>Create an account</h2>
                            <form onSubmit={handleSubmit(registerUser)}>
                                <div className="row">
                                    <div className="col-12">
                                        <input type="text" name="First name" className={errors.firstName ? 'input-error' : ''} {...register('firstName')} placeholder="First name"/>
                                        <span className="text-danger">{errors.firstName?.message}</span>
                                    </div>
                                    <div className="col-12">
                                        <input type="text" className={errors.lastName ? 'input-error' : ''} {...register('lastName')} name="lastName" placeholder="Last name"/>
                                        <span className="text-danger">{errors.lastName?.message}</span>
                                    </div>
                                    <div className="col-12">
                                        <input type="email" name="Email Address" className={errors.email ? 'input-error' : ''} {...register('email')} placeholder="Email Address"/>
                                        <span className="text-danger">{errors.email?.message}</span>
                                    </div>
                                    <div className="col-12">
                                        <input type="password" name="password" className={errors.password ? 'input-error' : ''} {...register('password')} placeholder="Password"/>
                                        <span className="text-danger">{errors.password?.message}</span>
                                    </div>
                                    <div className="col-12">
                                        <button type="submit" className="btn btn--primary type--uppercase"> Create Account </button>
                                    </div>
                                    <div className="col-12">
                                        <span className="type--fine-print block">Already have an account?
                                            <Link to="/auth/login">Login</Link>
                                        </span>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    )
}

export default Register
