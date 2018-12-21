// resources/assets/js/components/App.js

import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'

class App extends Component {
    render () {
        return (
            <BrowserRouter>
            <div>
            <Switch>
            <Route exact path='/' component={ProjectsList} />
        </Switch>
        </div>
        </BrowserRouter>
    )
    }
}
if( document.getElementById('app')) {
    // ReactDOM.render( < App / >, document.getElementById('app'))
}