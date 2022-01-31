import {Navigate} from "react-router-dom";
import Login from "../view/Login";
import Register from "../view/Register";

const authRoutes = (isLoggedIn)=> {
    return [
        {
            path: '/auth/login',
            element: !isLoggedIn ?  <Login /> : <Navigate to="/user/my-posts" />
        },
        {
            path: '/auth/register',
            element: !isLoggedIn ?  <Register /> : <Navigate to="/user/my-posts" />
        },
    ]
}

export default authRoutes;
