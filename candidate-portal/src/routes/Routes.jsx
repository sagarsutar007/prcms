import React from 'react';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom'
import Register from '../components/authentication/Register';

const Routes = () => {
  return (
    <Router>
      <Switch>
        <Route exact path="/" component={Register} />
        <Route path="/register" component={Register} />
      </Switch>
    </Router>
  );
};

export default Routes;
