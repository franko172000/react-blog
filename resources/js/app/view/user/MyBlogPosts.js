import Page from "../../components/Page";
import Blog from "../../components/Blog";
import {useEffect, useState} from "react";
import {getUserPosts} from "../../services/requests";
import Loader from "../../components/Loader";

const MyBlogPosts = ()=> {
    const [posts, setPosts] = useState();
    const [showLoader, setShowLoader] = useState();
    useEffect(async ()=>{
        await getPosts();
    },[]);

    const handlePagination = async (page)=>{
        await getPosts({
            page
        });
    }

    const getPosts = async (params) =>{
        setShowLoader(true);
        const res = await getUserPosts(params);
        setPosts(res.data);
        setShowLoader(false)
    }
    return (
        <>
            <Loader show={showLoader} />
            <div className="container">
                <div className="col-md-12">
                    <p>Hello Emmanuel</p>
                </div>
            </div>
            <Page
                title="My Blog Posts">
                <div className="masonry-filter-container d-flex align-items-center">
                    <span>Category:</span>
                    <div className="masonry-filter-holder">
                        <div className="masonry__filters" data-filter-all-text="All Categories"></div>
                    </div>
                </div>
                <hr />
                <Blog onPaginationClick={handlePagination} posts={posts} />
            </Page>
        </>
    )
}

export default MyBlogPosts;
