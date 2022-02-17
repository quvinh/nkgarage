import React from 'react';
import {
    Switch,
    Route,
    Link,
    Redirect
} from 'react-router-dom';
import Permission from './Permission';
import Roles from './Roles';
import AddRoles from './roles/Add';
import EditRoles from './roles/Edit';
import AddPermisson from './permission/Add';
import EditPermisson from './permission/Edit';

function Header() {
    return (
        <div>
            <ul className="nav justify-content-center">
                {/* <li className="nav-item">
                    <Link className="nav-link active" aria-current="page" to="/">Home</Link>
                </li> */}
                <li className="nav-item">
                    <Link className="nav-link" to="/permission">Permission</Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" to="/roles">Roles</Link>
                </li>
            </ul>
            <Switch>
                {/* <Route exact path='/' component={Home} /> */}
                <Route exact path='/permission' component={Permission}/>
                <Route exact path='/permission/edit/:id' component={EditPermisson} />
                <Route exact path='/permission/add' component={AddPermisson} />
                <Route exact path='/roles' component={Roles}/>
                <Route exact path='/roles/edit/:id' component={EditRoles} />
                <Route exact path='/roles/add' component={AddRoles} />
                {/* <Route exact path='/delete/:id' component={} /> */}
                {/* <Redirect to='/' /> */}
            </Switch>
        </div>
    );
}

export default Header;