<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-20 16:12:20
 * @LastEditTime: 2020-04-21 09:31:29
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\components\leftnav.vue
 -->
<template>
	<div>
    <el-menu
			default-active="1-1"
			class="el-menu-vertical-demo"
			@open="handleOpen"
			@close="handleClose"
			background-color="#545c64"
			text-color="#fff"
			active-text-color="#ffd04b">
			<el-submenu index="1">
				<template slot="title">
					<i class="el-icon-location"></i>
					<span>系统管理</span>
				</template>
				<el-menu-item-group>
					<el-menu-item index="1-1">学校管理</el-menu-item>
					<el-menu-item index="1-2">学生管理</el-menu-item>
				</el-menu-item-group>
			</el-submenu>
			<el-menu-item index="2">
				<i class="el-icon-menu"></i>
				<span slot="title">活动管理</span>
			</el-menu-item>
			<el-menu-item index="4">
				<i class="el-icon-setting"></i>
				<span slot="title">其他管理</span>
			</el-menu-item>
		</el-menu>
  </div>
</template>
<script>
export default {
  name: 'leftnav',
  data() {
    return {}
  },
  methods: {
		handleOpen (key, keyPath) {
			console.log(key, keyPath)
		},
		handleClose (key, keyPath) {
			console.log(key, keyPath)
		}
  }
}
</script>
<style scoped>

</style>
