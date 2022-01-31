import {Navigate} from "react-router-dom";
import MainLayout from "../layout/MainLayout";
import BlogPosts from "../view/BlogPosts";
import MyBlogPosts from "../view/user/MyBlogPosts";
import NewPost from "../view/user/NewPost";

const userRoutes = (isLoggedIn)=>{
    return [
        {
            path: '/user/',
            element: isLoggedIn ? <MainLayout /> : <Navigate to="/auth/login" />,
            children:[
                {path: 'my-posts', element: <MyBlogPosts />},
                {path: 'new-post', element: <NewPost />},
            ]
        }
    ]
}

export default userRoutes;
