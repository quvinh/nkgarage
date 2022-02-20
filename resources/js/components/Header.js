import React from 'react';
<<<<<<< HEAD
import Category from './Category';
import EditCategory from './category/Edit';
import AddCategory from './category/Add';
import Shelf from './Shelf';
import EditShelf from './shelf/Edit';
import AddShelf from './shelf/Add';
import Warehouse from './Warehouse';
import AddWarehouse from './warehouse/Add';
import EditWarehouse from './warehouse/Edit';
import Export from './export';
import AddExport from './export/Add';
import EditExport from './export/Edit';
import Detail_Item from './detail_item';
import AddDetailItem from './detail_item/Add';
import EditDetailItem from './detail_item/Edit';


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
                <li className="nav-item">
                    <Link className="nav-link" to="/warehouse">Warehouse</Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" to="/export">Export</Link>
                </li>
                <li className="nav-item">
                    <Link className="nav-link" to="/detail_item">Detail_Item</Link>
=======
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
import AddImport from './import/Add';
import EditImport from './import/Edit';

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
                <li className="nav-item">
                    <Link className="nav-link" to="/import">Import</Link>
>>>>>>> qvuong
                </li>
            </ul>
            <Switch>
                {/* <Route exact path='/' component={Home} /> */}
<<<<<<< HEAD
                <Route exact path='/category' component={Category} />
                <Route exact path='/category/edit/:id' component={EditCategory} />
                <Route exact path='/category/add' component={AddCategory} />
                <Route exact path='/shelf' component={Shelf} />
                <Route exact path='/shelf/edit/:id' component={EditShelf} />
                <Route exact path='/shelf/add' component={AddShelf} />
                <Route exact path='/warehouse' component={Warehouse} />
                <Route exact path='/warehouse/edit/:id' component={EditWarehouse} />
                <Route exact path='/warehouse/add' component={AddWarehouse} />
                <Route exact path='/export' component={Export} />
                <Route exact path='/export/edit/:id' component={EditExport} />
                <Route exact path='/export/add' component={AddExport} />
                <Route exact path='/detail_item' component={Detail_Item} />
                <Route exact path='/detail_item/edit/:id' component={EditDetailItem} />
                <Route exact path='/detail_item/add' component={AddDetailItem} />

=======
                <Route exact path='/permission' component={Permission}/>
                <Route exact path='/permission/edit/:id' component={EditPermisson} />
                <Route exact path='/permission/add' component={AddPermisson} />
                <Route exact path='/roles' component={Roles}/>
                <Route exact path='/roles/edit/:id' component={EditRoles} />
                <Route exact path='/roles/add' component={AddRoles} />
                <Route exact path= '/import/edit/:id' component={EditImport}/>
                <Route exact path= '/import/add' component={AddImport} />
                {/* <Route exact path='/delete/:id' component={} /> */}
>>>>>>> qvuong
                {/* <Redirect to='/' /> */}
            </Switch>
        </div>
    );
}

<<<<<<< HEAD
export default Header;
=======
export default Header;
>>>>>>> qvuong
