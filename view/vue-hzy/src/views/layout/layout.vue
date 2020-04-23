<!--
 * @Author: your name
 * @Date: 2020-04-20 15:02:10
 * @LastEditTime: 2020-04-23 09:14:28
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\views\layout\layout.vue
 -->
<template>
	<el-container>
		<!-- 头部 -->
		<el-header>
			<headerMain></headerMain>
		</el-header>
		<el-container>
			<!-- 左边 -->
			<el-aside width="170px">
				<leftNav></leftNav>
			</el-aside>
			<!-- 主 -->
			<el-main>
				<router-view/>
			</el-main>
		</el-container>
	</el-container>
</template>
<script>
import headerMain from '@/components/header.vue'
import leftNav from '@/components/leftnav.vue'
export default {
	name: 'layout',
	components: {
		headerMain,
		leftNav
	},
	data () {
		return {
		}
	},
	methods: {
	}
}
</script>
<style>
.el-header {
	background-color: #fff;
	color: #333;
	text-align:center;
	height: 50px !important;
	line-height:50px;
}
.el-aside {
	background-color: #D3DCE6;
	color: #333;
	text-align:center;
	/* line-height:200px; */
}
.el-main {
	background-color: #E9EEF3;
	color: #333;
	text-align:center;
	/* line-height:160px; */
}
.el-container{
  position: absolute;
  width: 100%;
  top: 0px;
  left: 0;
  bottom: 0;
}
.el-header{
  padding: 0;
  z-index: 1000;
}
/* header菜单需要靠右的添加.fr即可(如：<el-menu-item class="fr" index="3">消息中心</el-menu-item>) */
.el-header .fr{
  float: right;
}
.el-header .el-menu{
  border-bottom: none;
}
.el-aside, .el-main{
  padding-top: 60px;
}
.el-aside{
  background: #545c64;
}
.el-aside .el-menu{
  border-right: none;
}
</style>
