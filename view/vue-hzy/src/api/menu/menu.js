/*
 * @Author: fengmeifeng
 * @Date: 2020-04-23 10:25:15
 * @LastEditTime: 2020-04-23 14:18:55
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\api\menu\menu.js
 */
/**
 * @description: 栏目列表
 * @method GET
 * @param {munber} page 页码
 * @param {munber} pageSize 每页条数
 * @param {string} keyword 栏目名称
 * @param {munber} pid 父ID
 * @return:
 */
export const LISTS = '/menu'
/**
 * @description: 删除栏目
 * @method POST
 * @param {number} id 栏目ID
 * @return:
 */
export const DEL = '/menu/index//del'
