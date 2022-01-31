import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { useRoutes } from 'react-router-dom';
import routes from './routes';
import store from 'store'
import { AUTH_STORAGE_KEY } from './constants';
import {userLoaded} from "./store/entities/user";
const auth = store.get(AUTH_STORAGE_KEY);


const App = () => {
    const dispatch = useDispatch();
    useEffect(async ()=> {
        //pull logged in user
        if(auth?.isLoggedIn){
            dispatch(userLoaded({
                ...auth?.user
            }))
        }
    },[])

    const router = useRoutes(routes);
    return (
        <div className="main">
            {router}
        </div>
    )
}

export default App;
