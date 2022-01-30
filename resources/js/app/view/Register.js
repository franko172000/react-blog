import Nav from "../components/Nav";
import { useForm } from "react-hook-form";
import { yupResolver } from '@hookform/resolvers/yup';
import * as Yup from 'yup';

const Register = ()=>{
    const formValidationSchema = Yup.object().shape({
        firstName: Yup.string().required('first name is required'),
        lastName: Yup.string().required('last name is required'),
        email: Yup.string().required('email is required').email('email is invalid'),
        address: Yup.string().required('address is required'),
        phone: Yup.string()
            .min(10)
            .max(11)
            .required('Phone is required'),
        password: Yup.string().matches("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})", 'Password not valid'),
        conf_password: Yup.string().oneOf([Yup.ref('password'), null], 'Password must match').required('Confirm password is required')
    });

    const formOptions = { resolver: yupResolver(formValidationSchema)};
    // get functions to build form with useForm() hook
    const { register, handleSubmit, reset, formState } = useForm(formOptions);
    const { errors } = formState;
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
                            <form>
                                <div className="row">
                                    <div className="col-12">
                                        <input type="text" name="First name" placeholder="First name"/>
                                    </div>
                                    <div className="col-12">
                                        <input type="text" name="Last name" placeholder="Last name"/>
                                    </div>
                                    <div className="col-12">
                                        <input type="email" name="Email Address" placeholder="Email Address"/>
                                    </div>
                                    <div className="col-12">
                                        <input type="password" name="Password" placeholder="Password"/>
                                    </div>
                                    <div className="col-12">
                                        <button type="submit" className="btn btn--primary type--uppercase">Create
                                            Account
                                        </button>
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
