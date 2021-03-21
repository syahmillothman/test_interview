
const auth = (to,from,next) =>{
 
 if (!localStorage.getItem('token')) {
    return Vue.router.push({ name: 'login' });
  }

  return next();

}

export default auth;