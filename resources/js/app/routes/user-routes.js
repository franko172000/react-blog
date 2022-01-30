import {Navigate} from "react-router-dom";
import MainLayout from "../layout/MainLayout";
import BlogPosts from "../view/BlogPosts";

const userRoutes = (isLoggedIn)=>{
    return [
        {
            path: '/user/',
            element: isLoggedIn ? <MainLayout /> : <Navigate to="/auth/login" />,
            children:[
                {path: 'my-posts', element: <BlogPosts />},
                {path: 'add-post', element: <BlogPosts />},
            ]
        }
    ]
}

export default userRoutes;
