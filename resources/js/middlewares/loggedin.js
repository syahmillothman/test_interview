
const loggedIn = (to,from,next) => {

   if (localStorage.getItem('token')) {
      return Vue.router.push({ name: 'dashboard' });
  }

  return next();

}

export default loggedIn;