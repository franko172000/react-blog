import ApiClient from "../axios";

export const createUser = async (data)=> {
    return ApiClient.post( 'auth/register', data);
}
export const loginUser = async (data)=> {
    await ApiClient.get('/sanctum/csrf-cookie');
    return ApiClient.post('auth/login', data);
}
export const logout = async ()=> {
    return ApiClient.post( 'auth/logout');
}

export const getUserPosts = async (params)=> {
    return ApiClient.get( 'user/posts', {
        params
    });
}

export const createPost = async (data)=> {
    return ApiClient.post( 'user/add-post', data);
}

export const getAllPosts = async (params)=> {
    return ApiClient.get( '/posts', {
        params
    });
}

export const getPost = async (id)=> {
    return ApiClient.get( '/post/'+id);
}

export const getCategories = async ()=> {
    return ApiClient.get( '/categories');
}

