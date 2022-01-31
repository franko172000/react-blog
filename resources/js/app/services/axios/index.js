import axios from 'axios'
const getUrl = window.location;
const baseURL = getUrl .protocol + "//" + getUrl.host + "/spa/" ;

const ApiClient = axios.create({
  baseURL
})

ApiClient.interceptors.response.use(undefined, error => {
  const { response } = error
  return Promise.reject(error)
})

export default ApiClient
