<template>
  <div class="container-fluid">
    <header class="hero">
      <div class="hero-inner">
        <h1>Student Management System</h1>
        <p>A comprehensive platform for managing student records.</p>
      </div>
    </header>

    <section class="features">
      <h2>Features</h2>
      <ul class="list-group">
        <li class="list-group-item">
          <h3>Streamlined Student Registration</h3>
          <p>Easily register new students and manage their personal information.</p>
        </li>
        <li class="list-group-item">
          <h3>Effective Course Management</h3>
          <p>Organize and manage courses, including enrollment and attendance tracking.</p>
        </li>
        <li class="list-group-item">
          <h3>Comprehensive Performance Tracking</h3>
          <p>Monitor student progress and academic performance with detailed records.</p>
        </li>
        <li class="list-group-item">
          <h3>Seamless Reporting Generation</h3>
          <p>Generate customized reports on student data for analysis and decision-making.</p>
        </li>
      </ul>
    </section>

    <section class="call-to-action">
      <h2>Get Started Today</h2>
      <p>Experience the efficiency and power of our student management system.</p>
      <router-link class="btn btn-primary btn-lg" to="/register">Register</router-link>
    </section>
  </div>
</template>

<style scoped>
.hero {
  background-color: #f8f9fa;
  padding: 60px 0;
  text-align: center;
}

.hero-inner {
  max-width: 800px;
  margin: 0 auto;
}

.hero h1 {
  font-size: 4rem;
  font-weight: 700;
}

.hero p {
  font-size: 1.5rem;
}

.features {
  padding: 30px 0;
}

.features h2 {
  font-size: 2.5rem;
  font-weight: 700;
  text-align: center;
}

.features ul {
  list-style: none;
  padding: 0;
}

.features li {
  margin-bottom: 20px;
  padding: 10px 20px;
  border: 1px solid #ddd;
}

.features li h3 {
  font-size: 1.8rem;
  font-weight: 600;
}

.features li p {
  font-size: 1.2rem;
}

.call-to-action {
  padding: 60px 0;
  text-align: center;
}

.call-to-action h2 {
  font-size: 2.5rem;
  font-weight: 700;
}

.call-to-action p {
  font-size: 1.5rem;
}

.call-to-action a {
  font-size: 1.4rem;
  padding: 10px 20px;
  border-radius: 5px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
}

.list-group {
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
  list-style: none;
  padding: 0;

}

.list-group-item {
  margin: 10px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  text-align: justify;
  height: 150px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.list-group-item h3 {
  font-size: 20px !important;
  text-align: center;
  padding-bottom: 20px;
}

.list-group-item p {
  font-size: 14px !important;
  text-align: center;
  bottom: 0;
}
</style>
