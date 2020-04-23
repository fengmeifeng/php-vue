<!--
 * @Author: fengmeifeng
 * @Date: 2020-04-23 09:47:18
 * @LastEditTime: 2020-04-23 09:47:51
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \vue-hzy\src\components\pagination\pagination.vue
 -->
<template>
  <div>
    <el-pagination
      @current-change="handleCurrentChange"
      :current-page="pageNum"
      :page-size="pageSize"
      layout="total, prev, pager, next, jumper"
      :total="totalCount"
    ></el-pagination>
  </div>
</template>

<script>
export default {
  name: 'pagination',
  props: {
    pageSize: Number,
    pageNum: Number,
    totalCount: Number,
    // 不需要置顶的需要传false
    isScrollTop: null
  },
  data () {
    return {}
  },
  methods: {
    handleCurrentChange (currentPage) {
      console.info(currentPage)
      this.$emit('pageBar', currentPage)
      typeof this.isScrollTop === 'undefined' && window.scrollTo(0, 0)
    }
  }
}
</script>

<style lang="scss" scoped></style>
