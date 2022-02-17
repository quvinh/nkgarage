import React from 'react';
import Category from './Category';
import EditCategory from './category/Edit';
import AddCategory from './category/Add';
import Shelf from './Shelf';
import EditShelf from './shelf/Edit';
import AddShelf from './shelf/Add';
import { Link, Route, Switch } from 'react-router-dom';


function Header(props) {
    return (
        <div>
            <ul className="nav justify-content-center">
                <li className="nav-item">
                    <Link className="nav-link active" aria-current="page" to="/">Home</Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" to="/category">Category</Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" to="/shelf">Shelf</Link>
                </li>
            </ul>
            <Switch>
                {/* <Route exact path='/' component={Home} /> */}
                <Route exact path='/category' component={Category} />
                <Route exact path='/category/edit/:id' component={EditCategory} />
                <Route exact path='/category/add' component={AddCategory} />
                <Route exact path='/shelf' component={Shelf} />
                <Route exact path='/shelf/edit/:id' component={EditShelf} />
                <Route exact path='/shelf/add' component={AddShelf} />
                {/* <Redirect to='/' /> */}
            </Switch>
        </div>
    );
}

export default Header;
