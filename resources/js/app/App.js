import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { useRoutes } from 'react-router-dom';
import routes from './routes';
//import { getProfile } from './services/requests/users-requests';
import { userLoaded } from "./store/entities/user";
import store from 'store'
import { AUTH_STORAGE_KEY } from './constants';
const auth = store.get(AUTH_STORAGE_KEY);


const App = () => {
    const dispatch = useDispatch();
    useEffect(async ()=> {
        //pull logged in user
        // if(auth?.isLoggedIn){
        //     const response = await getProfile();
        //     dispatch(userLoaded({
        //         ...response.data.data
        //     }))
        // }
    },[])

    const router = useRoutes(routes);
    return (
        <div className="main">
            {router}
        </div>
    )
}

export default App;
