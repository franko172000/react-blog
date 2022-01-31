import axios from 'axios'
import store from "store";
import {AUTH_STORAGE_KEY} from "../../constants";
const getUrl = window.location;
const baseURL = getUrl .protocol + "//" + getUrl.host + "/spa/" ;

const ApiClient = axios.create({
  baseURL
})

ApiClient.interceptors.response.use(undefined, error => {
  const { response } = error
    const { data } = response
    if (data) {
      if(data.error_code === 'UNAUTHORIZED_ERROR' && response.status === 401){
          store.set(AUTH_STORAGE_KEY, null);
          window.location.href = '/auth/login';
      }
    }
  return Promise.reject(error)
})

export default ApiClient
