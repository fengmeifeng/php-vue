/*
 * @Author: your name
 * @Date: 2020-04-21 11:14:05
 * @LastEditTime: 2020-04-21 14:58:40
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\util\interceptor.js
 */
import axios from 'axios'
import router from '@/router'
import { errorMessage } from '@/util/message'
let baseUrl = ''
const ERROR_MSG = '长时间未操作，请重新登录'
const CODE = {
  '401': msg => {
    errorMessage(msg)
    router.push({ name: 'login' })
  },
  '50013': msg => {
    return errorMessage(msg)
  },
  '50014': msg => {
    errorMessage(msg)
    router.push({ name: 'login' })
  },
  '500': msg => {
    errorMessage(msg)
    return router.push({ name: 'login' })
  }
}
process.env.NODE_ENV === 'dev'
  ? (baseUrl = '/v2')
  : (baseUrl = process.env.VUE_APP_BASE_URL)
const service = axios.create({
  baseURL: baseUrl
})
axios.defaults.headers.post['Content-Type'] =
  'application/x-www-form-urlencoded;charset=UTF-8'
service.interceptors.request.use(
  config => {
    // eslint-disable-next-line no-unused-expressions
    localStorage.getItem('token')
      ? (config.headers.Authorization = localStorage.getItem('token'))
      : ''
    return config
  },
  error => {
    return error
  }
)
service.interceptors.response.use(
  response => {
    if (
      response.data.code === 401 ||
      response.data.code === 50013 ||
      response.data.code === 50014 ||
      (response.data.code === 500 && response.data.msg === ERROR_MSG)
    ) {
      CODE[response.data.code](response.data.msg)
    }
    // if (response.data.code === 401) {
    //   router.push({ name: "login" });
    // }
    return response
  },
  error => {
    return error
  }
)
export default service
