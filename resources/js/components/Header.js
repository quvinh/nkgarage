import React from 'react';
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
                <Route exact path='/warehouse' component={Warehouse} />
                <Route exact path='/warehouse/edit/:id' component={EditWarehouse} />
                <Route exact path='/warehouse/add' component={AddWarehouse} />
                <Route exact path='/export' component={Export} />
                <Route exact path='/export/edit/:id' component={EditExport} />
                <Route exact path='/export/add' component={AddExport} />
                <Route exact path='/detail_item' component={Detail_Item} />
                <Route exact path='/detail_item/edit/:id' component={EditDetailItem} />
                <Route exact path='/detail_item/add' component={AddDetailItem} />

                {/* <Redirect to='/' /> */}
            </Switch>
        </div>
    );
}

export default Header;
