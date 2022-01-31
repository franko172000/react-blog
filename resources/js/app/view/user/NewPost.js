import Page from "../../components/Page";
import Blog from "../../components/Blog";
import {useEffect, useState} from "react";
import {createPost, createUser, getCategories, getUserPosts} from "../../services/requests";
import Loader from "../../components/Loader";
import * as Yup from "yup";
import {yupResolver} from "@hookform/resolvers/yup";
import {useForm} from "react-hook-form";
import {useHttpError, useToast} from "../../hooks";
import {useNavigate} from "react-router-dom";
import {useSelector} from "react-redux";

const NewPost = ()=>{
    const [categories, setCategories] = useState([]);
    const [showLoader, setShowLoader] = useState(false);
    const {user} = useSelector((state)=> state.entities)
    useEffect(async ()=>{
        const res = await getCategories();
        setCategories(res.data.data);
    },[])
    const formValidationSchema = Yup.object().shape({
        title: Yup.string().required('Title is required'),
        description: Yup.string().required('description is required'),
        category: Yup.string().required('category is required')
    });

    const formOptions = { resolver: yupResolver(formValidationSchema)};
    // get functions to build form with useForm() hook
    const { register, handleSubmit, reset, formState } = useForm(formOptions);
    const { errors } = formState;
    const httpError = useHttpError();
    const toast = useToast();
    const navigate = useNavigate();

    const addPost = async (data)=>{
        setShowLoader(true)
        try{
            await createPost(data);
            toast("success", "Post Created Successfully");
            reset();
        }catch (err){
            httpError(err);
        }
        setShowLoader(false)
    }
    return (
        <>
            <div className="container">
                <div className="col-md-12">
                    <p>Hello {user.firstName}</p>
                </div>
            </div>
            <Page
                title="New Blog Post">
                <div className="row">
                    <div className="col-md-7 mx-auto">
                        <form onSubmit={handleSubmit(addPost)}>
                            <div className="row">
                                <div className="col-12">
                                    <label>Post Title</label>
                                    <input type="text" name="title" className={errors.title ? 'input-error' : ''} {...register('title')} placeholder="Post Title"/>
                                    <span className="text-danger">{errors.title?.message}</span>
                                </div>
                                <div className="col-12">
                                    <label>Post Category</label>
                                    <select name="category" className={errors.category ? 'input-error' : ''} {...register('category')}>
                                        <option defaultValue="" ></option>
                                        {
                                            categories.map(category => (<option value={category.id} key={category.id}>{category.name}</option>))
                                        }
                                    </select>
                                    <span className="text-danger">{errors.category?.message}</span>
                                </div>
                                <div className="col-12">
                                    <label>Description</label>
                                    <textarea name="description" {...register('description')} placeholder="Post description"></textarea>
                                    <span className="text-danger">{errors.description?.message}</span>
                                </div>
                                <div className="col-12">
                                    <button type="submit" className="btn btn--primary type--uppercase"> Create Post </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </Page>
        </>
    )
}

export default NewPost;
