import Nav from "../components/Nav";
import Footer from "../components/Footer";
import {Outlet} from "react-router-dom";

const MainLayout = ()=> {
    return(
        <>
            <Nav />
            <div className="main-container">
                <Outlet />
                <Footer />
            </div>
        </>
    )
}

export default MainLayout
