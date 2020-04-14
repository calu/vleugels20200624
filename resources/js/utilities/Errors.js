class Errors{
  constructor(){
    this.errors = {};
  }

  get(field){
    // console.log(this.errors);
    // console.log("\n" + this.errors);
    if (this.errors[field]){
      return this.errors[field][0];
    }
  }

  has(field){
    // console.log("field =" + field + " en errors = " + errors);
    return this.errors.hasOwnProperty(field);
  }

  any(){
    return Object.keys(this.errors).length > 0;
  }

  record(errors){
    this.errors = errors;
//   this.errors = errors.response.data.errors;
    // console.log("recorded  " + this.errors + "\n");
  }

  clear(field){
    if (field){
       delete this.errors[field];
       return;
     }

    this.errors={};
  }
};

export default Errors;
