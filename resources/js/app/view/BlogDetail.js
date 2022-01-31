import Page from "../components/Page";
import {useEffect, useState} from "react";
import Loader from "../components/Loader";
import {getPost} from "../services/requests";
import {useLocation} from "react-router-dom";

const BlogDetail = ()=> {
    const [post, setPost] = useState();
    const [showLoader, setShowLoader] = useState();
    const location = useLocation();
    useEffect(async ()=>{
        setShowLoader(true);
        const res = await getPost(location?.state?.postId);
        setPost(res.data.data)
        if(res.status === 404){
            //handle 404 error
        }
        setShowLoader(false)
    },[]);
    return (
        <>
            <Loader show={showLoader} />
            <Page
                title="Blog Detail">
                <section>
                    <div className="container">
                        <div className="row justify-content-center">
                            <div className="col-md-10 col-lg-8">
                                {
                                    post && (
                                        <article>
                                            <div className="article__title text-center">
                                                <h1 className="h2">{post.title}</h1>
                                                <span>{post.publicationDate} in </span>
                                                <span>
                                        <a href="#">{post.category}</a>
                                    </span>
                                            </div>
                                            <div className="article__body" dangerouslySetInnerHTML={{ __html: post.description }}></div>
                                        </article>
                                    )
                                }
                            </div>
                        </div>
                    </div>
                </section>
            </Page>
        </>
    )
}

export default BlogDetail;
