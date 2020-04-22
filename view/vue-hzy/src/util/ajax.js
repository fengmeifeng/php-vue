/*
 * @Author: fengmeifeng
 * @Date: 2020-04-21 10:49:19
 * @LastEditTime: 2020-04-21 16:27:38
 * @LastEditors: Please set LastEditors
 * @Description: 请求方式
 * @FilePath: \vue-hzy\src\util\ajax.js
 */
import service from './interceptor'
import qs from 'qs'
export async function postRequest (url, data) {
  const response = await service({
    method: 'post',
    url: url,
    data: qs.stringify(data)
  })
  return new Promise(resolve => {
    if (response.data.code === 200 || response.data.code === 500) {
      resolve(response.data)
    }
  })
}
export async function jsonRequest (url, data) {
  const response = await service({
    method: 'post',
    url: url,
    data: data,
    headers: {
      'Content-Type': 'application/json;charset=UTF-8'
    }
  })
  return new Promise(resolve => {
    console.warn(response)
    if (response.data.code === 200 || response.data.code === 500) {
      resolve(response.data)
    }
  })
}
export async function getRequest (url, data) {
  const response = await service.get(url, { params: data })
  return new Promise(resolve => {
    if (response.data.code === 200 || response.data.code === 500) {
      resolve(response.data)
    }
  })
}
export async function exportExcle (url, data, fileName) {
  const response = await service({
    method: 'post',
    url: url,
    data: data,
    headers: {
      'Content-Type': 'application/json;charset=UTF-8'
    },
    responseType: 'blob'
  })
  return new Promise(resolve => {
    console.log(response)
    resolve(response)
    let blob = new Blob([response.data], {
      type:
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8'
    })
    let downloadElement = document.createElement('a')
    let href = window.URL.createObjectURL(blob) // 创建下载的链接
    downloadElement.href = href
    downloadElement.download = `${fileName}` // 下载后文件名
    document.body.appendChild(downloadElement)
    downloadElement.click() // 点击下载
    document.body.removeChild(downloadElement) // 下载完成移除元素
    window.URL.revokeObjectURL(href) // 释放掉blob对象
  })
}
export async function exportFile (url, data, fileName) {
  const response = await service({
    method: 'post',
    url: url,
    data: data,
    headers: {
      'Content-Type': 'application/json;charset=UTF-8'
    },
    responseType: 'blob'
  })
  return new Promise(resolve => {
    console.log(response)
    resolve(response)
    let blob = new Blob([response.data], { type: 'application/zip' })
    let downloadElement = document.createElement('a')
    let href = window.URL.createObjectURL(blob) // 创建下载的链接
    console.log('链接', href)
    downloadElement.href = href
    downloadElement.download = `${fileName}` // 下载后文件名
    document.body.appendChild(downloadElement)
    downloadElement.click() // 点击下载
    document.body.removeChild(downloadElement) // 下载完成移除元素
    window.URL.revokeObjectURL(href) // 释放掉blob对象
  })
}
