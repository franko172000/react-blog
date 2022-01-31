import BlogCard from "./BlogCard";
import Pagination from "./Pagination";

const Page = ({children, title})=> {
    return (
        <section className="space--sm">
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <div className="masonry">
                            <div className="masonry-filter-container d-flex align-items-center">
                                <h1>{title}</h1>
                            </div>
                            <hr />
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default Page;
