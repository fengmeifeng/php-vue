<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-21 09:09:33
 * @LastEditTime: 2020-04-27 10:01:49
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\views\user\user.vue
 -->
<template>
  <div>
    <header>
      <el-menu
        :default-active="$route.path"
        class="el-menu-demo"
        mode="horizontal"
        @select="handleSelect"
      >
        <el-menu-item
          v-for="(item, index) in settingPath"
          :key="index"
          :index="item.path"
        >
          <a href="javascript:" @click="jumpItems(item.path)">{{
            item.name
          }}</a>
        </el-menu-item>
      </el-menu>
      <!-- <el-button
				class="m-b-20"
				v-for="(item,index) in  settingPath"
				:key="index"
				@click="jumpItems(item.path)"
			>{{item.name}}</el-button> -->
    </header>
    <section class="bg-fff">
      <router-view></router-view>
    </section>
  </div>
</template>
<script>
export default {
  name: 'personSetting',
  data () {
    return {
      settingPath: [
        { name: '基本信息', path: '/personalinfor/baseinfor' },
        { name: '安全设置', path: '/personalinfor/securitysetting' },
        // { name: "提醒设置", path: "/personalinfor/remindsetting"},
        { name: '登陆日志', path: '/personalinfor/loginglogs' }
      ]
    }
  },
  methods: {
    jumpItems (currentPath) {
      console.info('跳你妹' + currentPath)
      this.$router.push(currentPath)
    },
    handleSelect (key, keyPath) {
      console.log(key)
      console.log(keyPath)
    }
  }
}
</script>
<style scoped>
@import "../../assets/styles/less/atom.less";
</style>
