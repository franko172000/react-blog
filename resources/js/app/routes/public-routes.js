import {Navigate} from "react-router-dom";
import MainLayout from "../layout/MainLayout";
import BlogPosts from "../view/BlogPosts";
import MyBlogPosts from "../view/user/MyBlogPosts";
import BlogDetail from "../view/BlogDetail";

const publicRoutes = (isLoggedIn)=>{
    return [
        {
            path: '/',
            element: <MainLayout />,
            children:[
                {path: '/', element: <BlogPosts />},
                {path: 'post/detail', element: <BlogDetail />}
            ]
        }
    ]
}

export default publicRoutes;
