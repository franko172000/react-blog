import {Navigate} from "react-router-dom";
import MainLayout from "../layout/MainLayout";
import BlogPosts from "../view/BlogPosts";

const publicRoutes = (isLoggedIn)=>{
    return [
        {
            path: '/',
            element: <MainLayout />,
            children:[
                {path: '/', element: <BlogPosts />}
            ]
        }
    ]
}

export default publicRoutes;
